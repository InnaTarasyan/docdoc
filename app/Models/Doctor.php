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
}


