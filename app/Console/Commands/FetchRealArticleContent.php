<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use DOMXPath;

class FetchRealArticleContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:fetch-real-content 
                            {--limit=50 : Maximum number of articles to process}
                            {--min-length=1000 : Minimum content length to accept}
                            {--replace : Replace entire content instead of appending}
                            {--slug= : Process specific article by slug}
                            {--url= : Direct URL to fetch content from (use with --slug)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch real article content from internet sources based on blog post titles';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        $minLength = (int) $this->option('min-length');
        $replace = $this->option('replace');
        $slug = $this->option('slug');
        
        // Get posts to process
        if ($slug) {
            $posts = BlogPost::where('slug', $slug)->whereNotNull('published_at')->get();
        } else {
            $posts = BlogPost::whereNotNull('published_at')
                ->get()
                ->filter(function($post) use ($minLength) {
                    $contentLength = strlen(strip_tags($post->content));
                    return $contentLength < $minLength;
                })
                ->take($limit);
        }
        
        if ($posts->isEmpty()) {
            $this->warn('No posts found that need enhancement.');
            return self::SUCCESS;
        }
        
        $this->info("Processing {$posts->count()} blog posts...");
        $bar = $this->output->createProgressBar($posts->count());
        $bar->start();

        $enhanced = 0;
        $failed = 0;

        foreach ($posts as $post) {
            try {
                $this->line("\nProcessing: {$post->title}");
                
                // Get source URL - either from option or search
                $sourceUrl = $this->option('url');
                if (!$sourceUrl) {
                    $sourceUrl = $this->searchForArticle($post->title);
                }
                
                if (!$sourceUrl) {
                    $this->warn("  Could not find source URL for: {$post->title}");
                    $failed++;
                    $bar->advance();
                    continue;
                }
                
                $this->line("  Found source: {$sourceUrl}");
                
                // Fetch article content
                $fullContent = $this->fetchArticleContent($sourceUrl);
                
                if (!$fullContent || strlen(strip_tags($fullContent)) < $minLength) {
                    $this->warn("  Content too short or could not be extracted");
                    $failed++;
                    $bar->advance();
                    continue;
                }
                
                $contentLength = strlen(strip_tags($fullContent));
                $this->line("  Extracted {$contentLength} characters");
                
                // Update content
                if ($replace || strlen(strip_tags($post->content)) < 500) {
                    $post->content = $fullContent;
                } else {
                    // Clean existing content and append
                    $existingContent = preg_replace('/<p><a href="[^"]*"[^>]*>Read more<\/a><\/p>/i', '', $post->content);
                    $existingContent = preg_replace('/<p><a href="[^"]*"[^>]*>Read more<\/a>/i', '', $existingContent);
                    $existingContent = trim($existingContent);
                    $post->content = $existingContent . $fullContent;
                }
                
                // Save source URL
                $post->source_url = $sourceUrl;
                
                // Update read time
                $wordCount = str_word_count(strip_tags($post->content));
                $post->read_time = max(5, (int) ceil($wordCount / 200));
                
                $post->save();
                $enhanced++;
                $this->info("  ✓ Successfully updated");
                
            } catch (\Exception $e) {
                $failed++;
                $this->error("  ✗ Error: " . $e->getMessage());
            }
            
            $bar->advance();
            sleep(2); // Rate limiting
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully enhanced {$enhanced} blog posts.");
        if ($failed > 0) {
            $this->warn("Failed to enhance {$failed} blog posts.");
        }

        return self::SUCCESS;
    }

    /**
     * Search for article URL using web search
     */
    private function searchForArticle(string $title): ?string
    {
        try {
            // First, try searching on known medical sites directly
            $medicalSites = [
                'sleepfoundation.org',
                'webmd.com',
                'healthline.com',
                'medicalnewstoday.com',
                'mayoclinic.org',
                'health.harvard.edu',
                'clevelandclinic.org',
            ];
            
            // Extract key terms from title for site-specific search
            $keyTerms = $this->extractKeyTerms($title);
            
            foreach ($medicalSites as $site) {
                $searchQuery = urlencode($keyTerms . ' site:' . $site);
                $url = $this->tryDuckDuckGoSearch($searchQuery);
                if ($url && strpos($url, $site) !== false) {
                    return $url;
                }
            }
            
            // Try general web search
            $searchQueries = [
                $title,
                $title . ' article',
                $keyTerms . ' medical article',
            ];
            
            foreach ($searchQueries as $query) {
                $url = $this->tryDuckDuckGoSearch(urlencode($query));
                if ($url) {
                    return $url;
                }
            }
            
            return null;
        } catch (\Exception $e) {
            $this->warn("Search error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Extract key terms from title for better searching
     */
    private function extractKeyTerms(string $title): string
    {
        // Remove common words and extract meaningful terms
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'over', 'bad', 'this', 'rising', 'phenomenon', 'called', 'is', 'are', 'was', 'were'];
        $words = preg_split('/\s+/', strtolower($title));
        $keyWords = array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 3 && !in_array($word, $stopWords);
        });
        return implode(' ', array_slice($keyWords, 0, 5)); // Take first 5 key words
    }

    /**
     * Try DuckDuckGo search
     */
    private function tryDuckDuckGoSearch(string $query): ?string
    {
        try {
            $searchUrl = "https://html.duckduckgo.com/html/?q=" . $query;
            
            $response = Http::timeout(15)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9',
                ])
                ->get($searchUrl);
            
            if (!$response->successful()) {
                return null;
            }
            
            $html = $response->body();
            
            // Parse search results
            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            
            $xpath = new DOMXPath($dom);
            
            // Try different selectors for DuckDuckGo results
            $linkSelectors = [
                '//a[@class="result__a"]',
                '//a[contains(@class, "result")]',
                '//a[contains(@href, "http")]',
            ];
            
            foreach ($linkSelectors as $selector) {
                $links = $xpath->query($selector);
                
                if ($links && $links->length > 0) {
                    foreach ($links as $link) {
                        $url = $link->getAttribute('href');
                        
                        // Clean up DuckDuckGo redirect URLs
                        if (strpos($url, '/l/?kh=') !== false || strpos($url, '/l/?uddg=') !== false) {
                            // Extract actual URL from DuckDuckGo redirect
                            if (preg_match('/uddg=([^&]+)/', $url, $matches)) {
                                $url = urldecode($matches[1]);
                            } elseif (preg_match('/uddg=([^&]+)/', urldecode($url), $matches)) {
                                $url = urldecode($matches[1]);
                            }
                        }
                        
                        if ($url && (strpos($url, 'http') === 0)) {
                            // Check if it's likely an article
                            if ($this->isLikelyArticle($url)) {
                                return $url;
                            }
                        }
                    }
                }
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Check if URL is likely an article
     */
    private function isLikelyArticle(string $url): bool
    {
        $excluded = [
            'google.com', 'bing.com', 'duckduckgo.com', 'yahoo.com',
            'facebook.com', 'twitter.com', 'x.com', 'linkedin.com', 
            'youtube.com', 'instagram.com', 'pinterest.com',
            'reddit.com', 'quora.com', 'wikipedia.org',
            'amazon.com', 'ebay.com', 'shopify.com',
        ];
        
        foreach ($excluded as $exclude) {
            if (strpos($url, $exclude) !== false) {
                return false;
            }
        }
        
        // Prefer medical/health sites
        $preferred = [
            'webmd.com', 'mayoclinic.org', 'healthline.com', 'medicalnewstoday.com',
            'health.harvard.edu', 'cdc.gov', 'nih.gov', 'who.int',
            'clevelandclinic.org', 'hopkinsmedicine.org', 'medlineplus.gov',
            'sleepfoundation.org', 'heart.org', 'cancer.org', 'diabetes.org',
        ];
        
        foreach ($preferred as $pref) {
            if (strpos($url, $pref) !== false) {
                return true;
            }
        }
        
        // If not in preferred list, still accept if it looks like an article URL
        return !preg_match('/\.(jpg|jpeg|png|gif|webp|svg|pdf|zip|exe)(\?|$)/i', $url);
    }

    /**
     * Fetch article content from source URL
     */
    private function fetchArticleContent(string $url): ?string
    {
        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9',
                    'Accept-Encoding' => 'gzip, deflate, br',
                ])
                ->get($url);

            if (!$response->successful()) {
                return null;
            }

            $html = $response->body();
            
            // Parse HTML to extract article content
            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            
            $xpath = new DOMXPath($dom);
            
            // Enhanced article content selectors
            $selectors = [
                // Most specific first
                '//article//p[not(contains(@class, "ad")) and not(contains(@class, "advertisement")) and not(contains(@class, "newsletter")) and not(contains(@class, "subscribe"))]',
                '//div[contains(@class, "article-body")]//p',
                '//div[contains(@class, "article-content")]//p',
                '//div[contains(@class, "article-text")]//p',
                '//div[contains(@class, "post-content")]//p',
                '//div[contains(@class, "entry-content")]//p',
                '//div[@itemprop="articleBody"]//p',
                '//div[contains(@class, "story-body")]//p',
                '//div[contains(@class, "content-body")]//p',
                '//div[contains(@class, "post-body")]//p',
                '//div[contains(@class, "article-main")]//p',
                '//div[contains(@class, "main-content")]//p',
                '//main//p[not(contains(@class, "ad")) and not(contains(@class, "advertisement"))]',
                '//article//p',
                '//div[@role="article"]//p',
            ];
            
            $paragraphs = [];
            $seenTexts = [];
            
            foreach ($selectors as $selector) {
                $nodes = $xpath->query($selector);
                if ($nodes && $nodes->length > 0) {
                    foreach ($nodes as $node) {
                        $text = trim($node->textContent);
                        $text = preg_replace('/\s+/', ' ', $text);
                        
                        // Only include substantial paragraphs, exclude author bios, references, and editorial info
                        if (strlen($text) >= 50 
                            && !preg_match('/^(subscribe|newsletter|sign up|follow us|share this|advertisement|ad|cookie|privacy policy|terms of service|related articles|you may also like)/i', $text)
                            && !preg_match('/^(join our sleep care community|trusted hub of sleep health)/i', $text)
                            && !preg_match('/^(dr\.|doctor|md|phd)\s+[a-z]+ [a-z]+ is (a|an)/i', $text) // Author bio pattern with name
                            && !preg_match('/editorial team is dedicated|medical experts rigorously evaluate|highest standards for accuracy/i', $text)
                            && !preg_match('/^\d{4}[,\s].*retrieved.*from http/i', $text) // Full reference line
                            && !preg_match('/^[a-z]+, [a-z]\. [a-z]\. \(.*\)\./i', $text) // Full citation
                            && !in_array($text, $seenTexts)
                            && !preg_match('/^©\s*\d{4}/i', $text)
                            && !preg_match('/^all rights reserved/i', $text)) {
                            $paragraphs[] = $text;
                            $seenTexts[] = $text;
                        }
                    }
                    // If we found enough paragraphs, use them
                    if (count($paragraphs) >= 15) {
                        break;
                    }
                }
            }
            
            // If still not enough, try broader selectors
            if (count($paragraphs) < 20) {
                $broadSelectors = [
                    '//main//p[not(contains(@class, "ad"))]',
                    '//article//p',
                    '//div[@role="main"]//p',
                    '//div[contains(@class, "content")]//p[not(contains(@class, "ad"))]',
                ];
                
                foreach ($broadSelectors as $selector) {
                    $nodes = $xpath->query($selector);
                    if ($nodes && $nodes->length > 0) {
                        foreach ($nodes as $node) {
                            $text = trim($node->textContent);
                            $text = preg_replace('/\s+/', ' ', $text);
                            
                            if (strlen($text) >= 50 
                                && !preg_match('/^(subscribe|newsletter|sign up|follow us|share this|advertisement|ad|cookie|privacy)/i', $text)
                                && !preg_match('/^(join our sleep care community|trusted hub of sleep health)/i', $text)
                                && !preg_match('/^(dr\.|doctor|md|phd)\s+[a-z]+ [a-z]+ is (a|an)/i', $text)
                                && !preg_match('/editorial team is dedicated|medical experts rigorously evaluate|highest standards for accuracy/i', $text)
                                && !preg_match('/^\d{4}[,\s].*retrieved.*from http/i', $text)
                                && !preg_match('/^[a-z]+, [a-z]\. [a-z]\. \(.*\)\./i', $text)
                                && !in_array($text, $seenTexts)
                                && !preg_match('/^©\s*\d{4}/i', $text)) {
                                $paragraphs[] = $text;
                                $seenTexts[] = $text;
                            }
                        }
                        if (count($paragraphs) >= 15) {
                            break;
                        }
                    }
                }
            }
            
            if (empty($paragraphs)) {
                return null;
            }
            
            // Filter out author bios and editorial content from the beginning
            $filteredParagraphs = [];
            $skipCount = 0;
            foreach ($paragraphs as $index => $paragraph) {
                $paragraph = trim($paragraph);
                
                // Skip very short paragraphs
                if (strlen($paragraph) < 50) {
                    continue;
                }
                
                // Skip first few paragraphs if they look like author/editorial info
                if ($index < 3 && (
                    preg_match('/^(dr\.|doctor|md|phd)\s+[a-z]+ [a-z]+/i', $paragraph) ||
                    preg_match('/is (a|an) (writer|editor|physician|doctor)/i', $paragraph) ||
                    preg_match('/holds a (bachelor|master|degree)/i', $paragraph) ||
                    preg_match('/completed (his|her) (residency|fellowship)/i', $paragraph) ||
                    preg_match('/want to read more about/i', $paragraph)
                )) {
                    $skipCount++;
                    continue;
                }
                
                // Skip if it's clearly author/editorial content
                if (preg_match('/^(dr\.|doctor|md|phd)\s+[a-z]+ [a-z]+ is/i', $paragraph) ||
                    preg_match('/editorial team|medical experts rigorously/i', $paragraph)) {
                    continue;
                }
                
                $filteredParagraphs[] = $paragraph;
            }
            
            // If we filtered too much, use original paragraphs but skip first 2
            if (count($filteredParagraphs) < 5 && count($paragraphs) > 5) {
                $filteredParagraphs = array_slice($paragraphs, 2);
            }
            
            if (empty($filteredParagraphs)) {
                return null;
            }
            
            // Format as HTML paragraphs
            $htmlContent = '';
            foreach ($filteredParagraphs as $paragraph) {
                $paragraph = trim($paragraph);
                
                // Skip very short paragraphs
                if (strlen($paragraph) < 50) {
                    continue;
                }
                
                // Escape HTML but preserve structure
                $paragraph = htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8');
                $htmlContent .= '<p>' . $paragraph . '</p>' . "\n";
            }
            
            return $htmlContent;
            
        } catch (\Exception $e) {
            $this->warn("Fetch error for {$url}: " . $e->getMessage());
            return null;
        }
    }
}

