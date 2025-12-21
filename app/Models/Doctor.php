<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
	use HasFactory;

	protected $fillable = [
		'npi',
		'name',
		'gender',
		'city',
		'state',
		'taxonomy',
		'organization_name',
	];

	public function reviews()
	{
		return $this->hasMany(Review::class)->latest();
	}

	/**
	 * Get the blog posts authored by this doctor.
	 */
	public function blogPosts()
	{
		return $this->hasMany(BlogPost::class)->whereNotNull('published_at')->where('published_at', '<=', now())->latest('published_at');
	}
}


