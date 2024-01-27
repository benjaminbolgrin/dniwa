<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDomain extends Model
{
	use HasFactory;

	protected $table = 'user_domains';
	/**
	 * @var array<int, string> $fillable
	 */
	protected $fillable = ['user_id', 'domain_id'];

	# get the user
	/**
	 * @return BelongsTo<User, UserDomain>
	 */
	public function user(): BelongsTo{
		return $this->belongsTo(User::class);
	}

	# get the domain
	/**
	 * @return BelongsTo<Domain, UserDomain>
	 */
	public function domain(): BelongsTo{
		return $this->belongsTo(Domain::class);
	}
}
