<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo:

class UserDomain extends Model
{
	use HasFactory;

	protected $table = 'user_domains';
	protected $fillable = ['user_id', 'domain_id'];

	# get the user
	public function user(): BelongsTo{
		return $this->belongsTo(User::class);
	}

	# get the domain
	public function domain(): BelongsTo{
		return $this->belongsTo(Domain::class);
	}
}
