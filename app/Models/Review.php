<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	use HasFactory;

	protected $fillable = [
		'doctor_id',
		'name',
		'rating',
		'comment',
	];

	public function doctor()
	{
		return $this->belongsTo(Doctor::class);
	}
}


