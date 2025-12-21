<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CreateBlogAuthorDoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates fake doctor records for blog authors and links blog posts to them.
     * This enables author profile pages showing all articles by each doctor.
     */
    public function run(): void
    {
        // List of authors from blog posts
        $authors = [
            'Dr. Sarah Mitchell' => ['specialty' => 'Cardiology', 'city' => 'New York', 'state' => 'NY', 'gender' => 'F'],
            'Dr. James Anderson' => ['specialty' => 'Preventive Care', 'city' => 'Los Angeles', 'state' => 'CA', 'gender' => 'M'],
            'Dr. Emily Chen' => ['specialty' => 'Endocrinology', 'city' => 'San Francisco', 'state' => 'CA', 'gender' => 'F'],
            'Dr. Michael Thompson' => ['specialty' => 'Mental Health', 'city' => 'Chicago', 'state' => 'IL', 'gender' => 'M'],
            'Dr. Lisa Rodriguez' => ['specialty' => 'Nutrition', 'city' => 'Miami', 'state' => 'FL', 'gender' => 'F'],
            'Dr. Robert Martinez' => ['specialty' => 'Fitness', 'city' => 'Houston', 'state' => 'TX', 'gender' => 'M'],
            'Dr. Jennifer Kim' => ['specialty' => 'Oncology', 'city' => 'Seattle', 'state' => 'WA', 'gender' => 'F'],
            'Dr. Patricia Williams' => ['specialty' => 'Pediatrics', 'city' => 'Boston', 'state' => 'MA', 'gender' => 'F'],
            'Dr. David Park' => ['specialty' => 'Sleep Medicine', 'city' => 'Denver', 'state' => 'CO', 'gender' => 'M'],
            'Dr. Amanda Foster' => ['specialty' => 'Women\'s Health', 'city' => 'Phoenix', 'state' => 'AZ', 'gender' => 'F'],
            'Dr. Christopher Lee' => ['specialty' => 'Cardiology', 'city' => 'Atlanta', 'state' => 'GA', 'gender' => 'M'],
            'Dr. Maria Garcia' => ['specialty' => 'General Health', 'city' => 'Dallas', 'state' => 'TX', 'gender' => 'F'],
            'Dr. John Smith' => ['specialty' => 'General Health', 'city' => 'Philadelphia', 'state' => 'PA', 'gender' => 'M'],
            'Dr. Elizabeth Brown' => ['specialty' => 'General Health', 'city' => 'Portland', 'state' => 'OR', 'gender' => 'F'],
        ];

        $doctorMap = [];

        // Create or find doctors for each author
        foreach ($authors as $authorName => $details) {
            // Remove "Dr. " prefix for the name
            $nameWithoutPrefix = str_replace('Dr. ', '', $authorName);
            
            $doctor = Doctor::firstOrCreate(
                ['name' => $authorName],
                [
                    'npi' => 'BLOG' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                    'gender' => $details['gender'],
                    'city' => $details['city'],
                    'state' => $details['state'],
                    'taxonomy' => $details['specialty'],
                    'organization_name' => 'Medical Blog Contributor',
                ]
            );

            $doctorMap[$authorName] = $doctor->id;
        }

        // Link blog posts to doctors based on author name
        $blogPosts = BlogPost::whereNull('doctor_id')->get();
        
        foreach ($blogPosts as $post) {
            if (isset($doctorMap[$post->author])) {
                $post->doctor_id = $doctorMap[$post->author];
                $post->save();
            }
        }

        $this->command->info('Created ' . count($doctorMap) . ' doctor records and linked blog posts.');
    }
}
