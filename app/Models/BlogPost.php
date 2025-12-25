<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image_url',
        'author',
        'topic',
        'read_time',
        'published_at',
        'doctor_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the doctor that authored this blog post.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get a valid image URL or null if invalid.
     * Validates that the URL is not just a domain and appears to be a valid image URL.
     */
    public function getValidImageUrlAttribute()
    {
        $url = $this->image_url;
        
        // Return null if empty
        if (empty($url)) {
            return null;
        }
        
        // Check if it's a valid URL format
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }
        
        // Parse the URL to check its components
        $parsedUrl = parse_url($url);
        
        // Must have a scheme (http/https)
        if (!isset($parsedUrl['scheme']) || !in_array($parsedUrl['scheme'], ['http', 'https'])) {
            return null;
        }
        
        // Must have a host
        if (!isset($parsedUrl['host'])) {
            return null;
        }
        
        // Check if it's just a domain (no path or path is just "/")
        // Invalid examples: "https://www.webmd.com/" or "https://www.webmd.com"
        $path = $parsedUrl['path'] ?? '';
        $pathTrimmed = trim($path, '/');
        
        // If path is empty or just "/", it's invalid (just a domain)
        if (empty($pathTrimmed)) {
            return null;
        }
        
        // Additional check: if path doesn't contain any slashes after trimming,
        // it might still be valid (like a CDN URL with just an ID), but if it's
        // very short (less than 3 chars), it's likely invalid
        if (strlen($pathTrimmed) < 3 && strpos($pathTrimmed, '.') === false) {
            return null;
        }
        
        return $url;
    }
}
