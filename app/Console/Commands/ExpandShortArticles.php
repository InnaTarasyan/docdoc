<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;

class ExpandShortArticles extends Command
{
    protected $signature = 'blog:expand-short {--min-length=500 : Minimum content length in characters}';
    protected $description = 'Expand all blog posts with content shorter than the specified minimum length';

    public function handle(): int
    {
        $minLength = (int) $this->option('min-length');
        
        $shortPosts = BlogPost::whereNotNull('published_at')
            ->get()
            ->filter(function($post) use ($minLength) {
                return strlen(strip_tags($post->content)) < $minLength;
            });

        $count = $shortPosts->count();
        
        if ($count === 0) {
            $this->info('No short articles found.');
            return self::SUCCESS;
        }

        $this->info("Found {$count} short articles to expand.");
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $expanded = 0;

        foreach ($shortPosts as $post) {
            try {
                $expandedContent = $this->expandArticle($post);
                
                if ($expandedContent && strlen(strip_tags($expandedContent)) >= $minLength) {
                    $post->content = $expandedContent;
                    
                    // Update read time based on content length
                    $wordCount = str_word_count(strip_tags($expandedContent));
                    $post->read_time = max(5, (int) ceil($wordCount / 200)); // ~200 words per minute
                    
                    $post->save();
                    $expanded++;
                }
            } catch (\Exception $e) {
                $this->warn("\nError expanding post {$post->id}: " . $e->getMessage());
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully expanded {$expanded} articles.");

        return self::SUCCESS;
    }

    private function expandArticle(BlogPost $post): string
    {
        $currentContent = trim($post->content);
        $title = $post->title;
        $topic = $post->topic ?? 'General Health';
        
        // Remove any "Read more" links
        $currentContent = preg_replace('/<p><a href="[^"]*"[^>]*>Read more<\/a><\/p>/i', '', $currentContent);
        $currentContent = preg_replace('/<p><a href="[^"]*"[^>]*>Read more<\/a>/i', '', $currentContent);
        $currentContent = trim($currentContent);
        
        // Clean up nested paragraph tags
        $currentContent = preg_replace('/<p[^>]*><p[^>]*>/i', '<p>', $currentContent);
        $currentContent = preg_replace('/<\/p><\/p>/i', '</p>', $currentContent);
        
        // If current content is very short or just a link, start fresh
        if (strlen(strip_tags($currentContent)) < 100) {
            $currentContent = '';
        }
        
        // Generate comprehensive content based on title and topic
        $expandedContent = $this->generateComprehensiveContent($title, $topic, $currentContent);
        
        return $expandedContent;
    }

    private function generateComprehensiveContent(string $title, string $topic, string $existingContent): string
    {
        $content = '';
        
        // Start with existing content if it's meaningful
        if (!empty($existingContent) && strlen(strip_tags($existingContent)) > 50) {
            $content = $existingContent;
            if (!str_ends_with($content, '</p>')) {
                $content = '<p>' . strip_tags($content) . '</p>';
            }
        } else {
            // Create an introduction paragraph
            $content = '<p>' . $this->generateIntroduction($title, $topic) . '</p>';
        }
        
        // Generate main content sections
        $sections = $this->generateContentSections($title, $topic);
        $content .= $sections;
        
        // Add conclusion
        $content .= '<p>' . $this->generateConclusion($title, $topic) . '</p>';
        
        return $content;
    }

    private function generateIntroduction(string $title, string $topic): string
    {
        $introductions = [
            "Understanding {$title} is essential for maintaining optimal health and well-being. This comprehensive guide explores the latest research, expert insights, and practical recommendations to help you make informed decisions about your health.",
            "When it comes to {$topic}, staying informed about current research and best practices can significantly impact your health outcomes. This article delves into {$title}, providing evidence-based information and actionable advice.",
            "{$title} represents an important aspect of {$topic} that deserves careful consideration. Through examining recent studies, expert opinions, and practical applications, we aim to provide you with valuable insights into this topic.",
            "Navigating the complexities of {$topic} requires access to reliable, up-to-date information. This article on {$title} offers a thorough examination of the subject, combining scientific evidence with practical guidance.",
        ];
        
        return $introductions[array_rand($introductions)];
    }

    private function generateContentSections(string $title, string $topic): string
    {
        $sections = '';
        
        // Generate 3-5 main sections with headings
        $sectionTitles = $this->generateSectionTitles($title, $topic);
        
        foreach ($sectionTitles as $sectionTitle) {
            $sections .= '<h2>' . htmlspecialchars($sectionTitle) . '</h2>';
            $sections .= '<p>' . $this->generateSectionContent($sectionTitle, $topic) . '</p>';
            $sections .= '<p>' . $this->generateSectionContent($sectionTitle, $topic) . '</p>';
        }
        
        return $sections;
    }

    private function generateSectionTitles(string $title, string $topic): array
    {
        // Generate relevant section titles based on common health article patterns
        $commonSections = [
            'Key Factors and Considerations',
            'Current Research and Findings',
            'Practical Applications and Recommendations',
            'Expert Insights and Best Practices',
            'Prevention and Management Strategies',
            'Understanding the Science',
            'Common Questions and Answers',
            'What You Need to Know',
        ];
        
        // Select 3-4 sections
        shuffle($commonSections);
        return array_slice($commonSections, 0, rand(3, 4));
    }

    private function generateSectionContent(string $sectionTitle, string $topic): string
    {
        $templates = [
            "When examining {$sectionTitle} in the context of {$topic}, it becomes clear that multiple factors contribute to overall outcomes. Research consistently demonstrates that a comprehensive approach, considering both individual circumstances and broader medical evidence, yields the best results. Healthcare professionals emphasize the importance of personalized care that takes into account unique health profiles and medical histories.",
            
            "Recent studies in the field of {$topic} have provided valuable insights into {$sectionTitle}. These findings highlight the evolving nature of medical understanding and the importance of staying current with the latest research. Evidence-based practices continue to shape recommendations, ensuring that patients receive care grounded in scientific validation.",
            
            "Understanding {$sectionTitle} requires consideration of various perspectives within {$topic}. Medical experts agree that a holistic approach, addressing multiple aspects of health and wellness, often produces more favorable outcomes than focusing on isolated factors. This comprehensive view helps individuals make informed decisions about their healthcare.",
            
            "The relationship between {$sectionTitle} and {$topic} is complex and multifaceted. Current medical literature suggests that effective management involves understanding underlying mechanisms, recognizing individual variations, and applying evidence-based interventions. Healthcare providers play a crucial role in guiding patients through these considerations.",
            
            "When addressing {$sectionTitle}, it's important to recognize that {$topic} encompasses a wide range of considerations. Medical professionals recommend taking a proactive approach that includes regular monitoring, preventive measures, and timely intervention when necessary. This strategy helps maintain optimal health outcomes over time.",
        ];
        
        return $templates[array_rand($templates)];
    }

    private function generateConclusion(string $title, string $topic): string
    {
        $conclusions = [
            "In conclusion, {$title} represents an important aspect of {$topic} that warrants careful attention and informed decision-making. By staying informed about current research, consulting with qualified healthcare professionals, and taking a proactive approach to health management, individuals can work toward optimal outcomes. Remember that personalized care and evidence-based practices are essential components of effective health management.",
            
            "To summarize, understanding {$title} within the broader context of {$topic} provides valuable insights for maintaining and improving health. The information presented here offers a foundation for informed discussions with healthcare providers and supports evidence-based decision-making. As research continues to evolve, staying current with the latest findings and recommendations remains important for optimal health outcomes.",
            
            "In summary, {$title} is a significant consideration within {$topic} that benefits from a comprehensive, evidence-based approach. The key to effective management lies in understanding the underlying factors, staying informed about current research, and working collaboratively with healthcare professionals. By taking these steps, individuals can make informed choices that support their health and well-being.",
        ];
        
        return $conclusions[array_rand($conclusions)];
    }
}

