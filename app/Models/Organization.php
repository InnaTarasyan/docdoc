<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	use HasFactory;

	protected $fillable = [
		'npi',
		'name',
		'city',
		'state',
		'phone',
	];

	public function reviews()
	{
		return $this->hasMany(Review::class)->latest();
	}
}


