<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;

class EnhanceBlogPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:enhance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enhance all blog posts with additional paragraphs and ensure HTML is properly rendered';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $posts = BlogPost::all();
        $bar = $this->output->createProgressBar($posts->count());
        $bar->start();

        $enhanced = 0;

        foreach ($posts as $post) {
            // Unescape HTML entities if they exist
            $content = html_entity_decode($post->content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            
            // Check if content already has proper HTML structure
            $hasParagraphs = strpos($content, '<p>') !== false || strpos($content, '</p>') !== false;
            
            // If content doesn't end with a closing paragraph tag, ensure it does
            $content = trim($content);
            if (!$hasParagraphs && !empty($content)) {
                // Wrap existing content in paragraph tags if it's plain text
                $content = '<p>' . $content . '</p>';
            }
            
            // Add additional paragraphs if content is short or doesn't have enough paragraphs
            $paragraphCount = substr_count($content, '<p>');
            
            if ($paragraphCount < 3) {
                $additionalContent = $this->generateAdditionalParagraphs($post);
                $content .= $additionalContent;
            }
            
            // Ensure content doesn't have escaped HTML tags showing as text
            // Replace any escaped tags that might be showing as text
            $content = str_replace(['&lt;p&gt;', '&lt;/p&gt;', '&lt;em&gt;', '&lt;/em&gt;', '&lt;strong&gt;', '&lt;/strong&gt;'], 
                                  ['<p>', '</p>', '<em>', '</em>', '<strong>', '</strong>'], $content);
            
            // Update the post
            $post->content = $content;
            $post->save();
            
            $enhanced++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully enhanced {$enhanced} blog posts.");

        return self::SUCCESS;
    }

    /**
     * Generate additional paragraphs based on the post topic
     */
    private function generateAdditionalParagraphs(BlogPost $post): string
    {
        $topic = $post->topic ?? 'General Health';
        
        $paragraphs = [
            '<p>Understanding the nuances of ' . strtolower($topic) . ' requires a comprehensive approach that considers both individual circumstances and broader medical research. Medical professionals emphasize the importance of personalized care and evidence-based practices when addressing health concerns.</p>',
            '<p>Recent studies have shed light on various aspects of ' . strtolower($topic) . ', providing new insights that can help individuals make informed decisions about their health. It\'s essential to consult with qualified healthcare providers who can offer guidance tailored to your specific needs and medical history.</p>',
            '<p>When considering treatment options or lifestyle changes related to ' . strtolower($topic) . ', it\'s important to weigh the potential benefits against any risks. Open communication with your healthcare team ensures that you receive the most appropriate care and support throughout your health journey.</p>',
            '<p>Preventive measures and early intervention play crucial roles in maintaining optimal health outcomes. Staying informed about the latest research and recommendations in ' . strtolower($topic) . ' can empower you to take proactive steps toward better health and well-being.</p>',
        ];

        return implode('', $paragraphs);
    }
}

