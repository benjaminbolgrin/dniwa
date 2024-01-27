<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
	use HasFactory;
	/**
	 * @var array<string, string> $attributes
	*/
	protected $attributes = [
		'theme' => 'light'
	];
	/**
	 * @var array<int, string> $fillable
	 */
	protected $fillable = [
		'user_id'
	];
	
	/**
	 * @return BelongsTo<User, UserSetting>
	 */
	public function user(): BelongsTo{
		return $this->belongsTo(User::class);
	}
}
