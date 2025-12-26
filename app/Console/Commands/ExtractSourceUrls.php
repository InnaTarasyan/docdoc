<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;

class ExtractSourceUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:extract-source-urls {--all : Process all posts, including those with existing source_url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract and save source URLs from blog post content for all posts';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $processAll = $this->option('all');
        
        // Get posts that don't have source_url or all posts if --all flag is set
        $query = BlogPost::whereNotNull('published_at');
        
        if (!$processAll) {
            $query->whereNull('source_url');
        }
        
        $posts = $query->get();
        
        if ($posts->isEmpty()) {
            $this->info('No posts found to process.');
            return self::SUCCESS;
        }
        
        $this->info("Processing {$posts->count()} posts...");
        
        $bar = $this->output->createProgressBar($posts->count());
        $bar->start();
        
        $updated = 0;
        $skipped = 0;
        
        foreach ($posts as $post) {
            // Skip if source_url already exists and we're not processing all
            if (!$processAll && !empty($post->source_url)) {
                $skipped++;
                $bar->advance();
                continue;
            }
            
            // Extract source URL from content
            $sourceUrl = $this->extractSourceUrl($post->content);
            
            if ($sourceUrl) {
                // Validate URL
                if (filter_var($sourceUrl, FILTER_VALIDATE_URL) && preg_match('/^https?:\/\//', $sourceUrl)) {
                    $post->source_url = $sourceUrl;
                    $post->save();
                    $updated++;
                } else {
                    $skipped++;
                }
            } else {
                $skipped++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info("Successfully updated {$updated} posts with source URLs.");
        if ($skipped > 0) {
            $this->warn("Skipped {$skipped} posts (no extractable source URL found).");
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
}

