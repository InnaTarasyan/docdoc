<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	use HasFactory;

	protected $fillable = [
		'doctor_id',
		'organization_id',
		'name',
		'rating',
		'comment',
	];

	public function doctor()
	{
		return $this->belongsTo(Doctor::class);
	}

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}






