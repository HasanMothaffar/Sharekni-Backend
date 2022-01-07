<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
	use HasFactory;

	protected $hidden = [
		'created_at',
		'updated_at',
		'product_id'
	];

	protected $fillable = [
		'percentage',
		'days_before_expiration'
	];
}
