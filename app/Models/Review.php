<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	use HasFactory;

	protected $fillable = [
		'comment'
	];

	protected $hidden = [
		'product_id',
		'user_id'
	];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
