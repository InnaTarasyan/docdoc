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
    protected $signature = 'blog:enhance-from-sources {--limit=50 : Maximum number of articles to enhance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch additional paragraphs from original article sources';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        
        // Get posts that might have source URLs in their content
        $posts = BlogPost::where('content', 'like', '%<a href=%')
            ->orWhere('content', 'like', '%Read more%')
            ->limit($limit)
            ->get();
        
        if ($posts->isEmpty()) {
            $this->warn('No posts found with source URLs. Trying to enhance all posts by searching for original sources...');
            $posts = BlogPost::limit($limit)->get();
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
                    $additionalContent = $this->fetchArticleContent($sourceUrl);
                    
                    if ($additionalContent) {
                        // Remove any existing "Read more" link from content
                        $content = preg_replace('/<p><a href="[^"]*"[^>]*>Read more<\/a><\/p>/i', '', $post->content);
                        $content = preg_replace('/<p><a href="[^"]*"[^>]*>Read more<\/a>/i', '', $content);
                        $content = trim($content);
                        
                        // Clean up any nested paragraph tags or div tags
                        $content = preg_replace('/<div[^>]*>/i', '', $content);
                        $content = preg_replace('/<\/div>/i', '', $content);
                        $content = preg_replace('/<p[^>]*><p[^>]*>/i', '<p>', $content);
                        $content = preg_replace('/<\/p><\/p>/i', '</p>', $content);
                        
                        // Add the additional paragraphs
                        $post->content = $content . $additionalContent;
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
        // This is a placeholder - in a real scenario, you might use a search API
        // or check if the title matches known sources
        return null;
    }

    /**
     * Fetch article content from source URL
     */
    private function fetchArticleContent(string $url): ?string
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
                '//article//p[not(@class="advertisement") and not(@class="ad")]',
                '//div[@class="article-body"]//p',
                '//div[@class="article-content"]//p',
                '//div[@class="content"]//p',
                '//div[@class="post-content"]//p',
                '//div[@class="entry-content"]//p',
                '//div[@itemprop="articleBody"]//p',
                '//main//p[not(@class="advertisement")]',
                '//div[@class="story-body"]//p',
                '//div[@class="article-text"]//p',
            ];
            
            $paragraphs = [];
            
            foreach ($selectors as $selector) {
                $nodes = $xpath->query($selector);
                if ($nodes && $nodes->length > 0) {
                    foreach ($nodes as $node) {
                        $text = trim($node->textContent);
                        // Only include substantial paragraphs (at least 50 characters)
                        // Exclude common non-content text
                        if (strlen($text) >= 50 
                            && !preg_match('/^(subscribe|newsletter|sign up|follow us|share this)/i', $text)
                            && !in_array($text, $paragraphs)) {
                            $paragraphs[] = $text;
                        }
                    }
                    // If we found enough paragraphs with this selector, use them
                    if (count($paragraphs) >= 3) {
                        break;
                    }
                }
            }
            
            // If no paragraphs found with specific selectors, try to extract from main content area
            if (count($paragraphs) < 3) {
                $mainSelectors = [
                    '//main//p',
                    '//article//p',
                    '//div[@role="main"]//p',
                ];
                
                foreach ($mainSelectors as $selector) {
                    $nodes = $xpath->query($selector);
                    if ($nodes && $nodes->length > 0) {
                        foreach ($nodes as $node) {
                            $text = trim($node->textContent);
                            if (strlen($text) >= 50 
                                && !preg_match('/^(subscribe|newsletter|sign up|follow us|share this|advertisement|ad)/i', $text)
                                && !in_array($text, $paragraphs)) {
                                $paragraphs[] = $text;
                            }
                        }
                        if (count($paragraphs) >= 3) {
                            break;
                        }
                    }
                }
            }
            
            // Get 3-5 additional paragraphs (avoid taking too many)
            $additionalParagraphs = array_slice($paragraphs, 0, 5);
            
            if (empty($additionalParagraphs)) {
                return null;
            }
            
            // Format as HTML paragraphs
            $htmlContent = '';
            foreach ($additionalParagraphs as $paragraph) {
                // Clean up the text - remove extra whitespace but preserve structure
                $paragraph = preg_replace('/\s+/', ' ', $paragraph);
                $paragraph = trim($paragraph);
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

