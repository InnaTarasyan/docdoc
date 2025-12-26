<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use DOMXPath;

class EnhanceBlogPostsFromSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:enhance-from-sources {--limit=50 : Maximum number of articles to enhance} {--min-length=500 : Minimum content length to trigger fetching} {--replace : Replace entire content instead of appending}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch full article content from original sources on the internet';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        $minLength = (int) $this->option('min-length');
        $replace = $this->option('replace');
        
        // Get posts that are short or have source URLs
        $posts = BlogPost::whereNotNull('published_at')
            ->get()
            ->filter(function($post) use ($minLength) {
                $contentLength = strlen(strip_tags($post->content));
                return $contentLength < $minLength || 
                       strpos($post->content, '<a href=') !== false ||
                       strpos($post->content, 'Read more') !== false;
            })
            ->take($limit);
        
        if ($posts->isEmpty()) {
            $this->warn('No posts found that need enhancement.');
            return self::SUCCESS;
        }
        
        $bar = $this->output->createProgressBar($posts->count());
        $bar->start();

        $enhanced = 0;
        $failed = 0;

        foreach ($posts as $post) {
            try {
                $sourceUrl = $this->extractSourceUrl($post->content);
                
                if (!$sourceUrl) {
                    // Try to find source URL by searching with the title
                    $sourceUrl = $this->findSourceUrlByTitle($post->title);
                }
                
                if ($sourceUrl) {
                    $fullContent = $this->fetchArticleContent($sourceUrl, true);
                    
                    if ($fullContent && strlen(strip_tags($fullContent)) >= $minLength) {
                        if ($replace || strlen(strip_tags($post->content)) < 200) {
                            // Replace entire content
                            $post->content = $fullContent;
                        } else {
                            // Append to existing content
                            $content = preg_replace('/<p><a href="[^"]*"[^>]*>Read more<\/a><\/p>/i', '', $post->content);
                            $content = preg_replace('/<p><a href="[^"]*"[^>]*>Read more<\/a>/i', '', $content);
                            $content = trim($content);
                            
                            // Clean up any nested paragraph tags or div tags
                            $content = preg_replace('/<div[^>]*>/i', '', $content);
                            $content = preg_replace('/<\/div>/i', '', $content);
                            $content = preg_replace('/<p[^>]*><p[^>]*>/i', '<p>', $content);
                            $content = preg_replace('/<\/p><\/p>/i', '</p>', $content);
                            
                            $post->content = $content . $fullContent;
                        }
                        
                        // Update read time
                        $wordCount = str_word_count(strip_tags($post->content));
                        $post->read_time = max(5, (int) ceil($wordCount / 200));
                        
                        $post->save();
                        $enhanced++;
                    } else {
                        $failed++;
                    }
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
                $this->warn("\nError processing post {$post->id}: " . $e->getMessage());
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
     * Extract source URL from article content
     */
    private function extractSourceUrl(string $content): ?string
    {
        // Look for "Read more" links
        if (preg_match('/<a href="([^"]+)"[^>]*>Read more<\/a>/i', $content, $matches)) {
            return $matches[1];
        }
        
        // Look for any external links
        if (preg_match('/<a href="(https?:\/\/[^"]+)"[^>]*>/i', $content, $matches)) {
            $url = $matches[1];
            // Only use if it's not an image URL
            if (!preg_match('/\.(jpg|jpeg|png|gif|webp|svg)(\?|$)/i', $url)) {
                return $url;
            }
        }
        
        return null;
    }

    /**
     * Try to find source URL by searching with article title
     */
    private function findSourceUrlByTitle(string $title): ?string
    {
        try {
            // Use DuckDuckGo HTML search (no API key needed)
            $searchQuery = urlencode($title);
            $searchUrl = "https://html.duckduckgo.com/html/?q={$searchQuery}";
            
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
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
            
            // Look for result links
            $links = $xpath->query('//a[@class="result__a"]');
            
            if ($links && $links->length > 0) {
                // Get first result that looks like an article
                foreach ($links as $link) {
                    $url = $link->getAttribute('href');
                    if ($url && (strpos($url, 'http') === 0)) {
                        // Check if it's likely an article (not a search engine or social media)
                        $excluded = ['google.com', 'bing.com', 'duckduckgo.com', 'facebook.com', 'twitter.com', 'linkedin.com', 'youtube.com'];
                        $isExcluded = false;
                        foreach ($excluded as $exclude) {
                            if (strpos($url, $exclude) !== false) {
                                $isExcluded = true;
                                break;
                            }
                        }
                        
                        if (!$isExcluded) {
                            return $url;
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
     * Fetch article content from source URL
     */
    private function fetchArticleContent(string $url, bool $fullContent = false): ?string
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.5',
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
            
            // Common article content selectors (ordered by specificity)
            $selectors = [
                '//article//p[not(contains(@class, "advertisement")) and not(contains(@class, "ad")) and not(contains(@class, "newsletter"))]',
                '//div[contains(@class, "article-body")]//p',
                '//div[contains(@class, "article-content")]//p',
                '//div[contains(@class, "article-text")]//p',
                '//div[contains(@class, "post-content")]//p',
                '//div[contains(@class, "entry-content")]//p',
                '//div[@itemprop="articleBody"]//p',
                '//div[contains(@class, "story-body")]//p',
                '//div[contains(@class, "content-body")]//p',
                '//div[contains(@class, "post-body")]//p',
                '//main//p[not(contains(@class, "advertisement")) and not(contains(@class, "ad"))]',
                '//article//p',
            ];
            
            $paragraphs = [];
            $seenTexts = [];
            
            foreach ($selectors as $selector) {
                $nodes = $xpath->query($selector);
                if ($nodes && $nodes->length > 0) {
                    foreach ($nodes as $node) {
                        $text = trim($node->textContent);
                        $text = preg_replace('/\s+/', ' ', $text);
                        
                        // Only include substantial paragraphs (at least 50 characters)
                        // Exclude common non-content text
                        if (strlen($text) >= 50 
                            && !preg_match('/^(subscribe|newsletter|sign up|follow us|share this|advertisement|ad|cookie|privacy policy|terms of service)/i', $text)
                            && !in_array($text, $seenTexts)
                            && !preg_match('/^©\s*\d{4}/i', $text)) {
                            $paragraphs[] = $text;
                            $seenTexts[] = $text;
                        }
                    }
                    // If we found enough paragraphs with this selector and not requesting full content, use them
                    if (!$fullContent && count($paragraphs) >= 10) {
                        break;
                    }
                }
            }
            
            // If no paragraphs found with specific selectors, try to extract from main content area
            if (count($paragraphs) < 5) {
                $mainSelectors = [
                    '//main//p[not(contains(@class, "ad"))]',
                    '//article//p',
                    '//div[@role="main"]//p',
                    '//div[contains(@class, "content")]//p',
                ];
                
                foreach ($mainSelectors as $selector) {
                    $nodes = $xpath->query($selector);
                    if ($nodes && $nodes->length > 0) {
                        foreach ($nodes as $node) {
                            $text = trim($node->textContent);
                            $text = preg_replace('/\s+/', ' ', $text);
                            
                            if (strlen($text) >= 50 
                                && !preg_match('/^(subscribe|newsletter|sign up|follow us|share this|advertisement|ad|cookie|privacy)/i', $text)
                                && !in_array($text, $seenTexts)
                                && !preg_match('/^©\s*\d{4}/i', $text)) {
                                $paragraphs[] = $text;
                                $seenTexts[] = $text;
                            }
                        }
                        if (!$fullContent && count($paragraphs) >= 10) {
                            break;
                        }
                    }
                }
            }
            
            // If full content requested, get all paragraphs; otherwise limit to 5
            if ($fullContent) {
                $selectedParagraphs = $paragraphs;
            } else {
                $selectedParagraphs = array_slice($paragraphs, 0, 5);
            }
            
            if (empty($selectedParagraphs)) {
                return null;
            }
            
            // Format as HTML paragraphs
            $htmlContent = '';
            foreach ($selectedParagraphs as $paragraph) {
                // Clean up the text - remove extra whitespace but preserve structure
                $paragraph = preg_replace('/\s+/', ' ', $paragraph);
                $paragraph = trim($paragraph);
                
                // Skip very short paragraphs
                if (strlen($paragraph) < 50) {
                    continue;
                }
                
                // Escape HTML but preserve the paragraph structure
                $paragraph = htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8');
                $htmlContent .= '<p>' . $paragraph . '</p>';
            }
            
            return $htmlContent;
            
        } catch (\Exception $e) {
            $this->warn("\nError fetching from {$url}: " . $e->getMessage());
            return null;
        }
    }
}

