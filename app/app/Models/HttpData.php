<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HttpData extends Model
{
	use HasFactory;

    	protected $table = 'http_data';
	/**
	 * @var array<string, string>
	 */
	protected $attributes = ['title' => ''];
	/**
	 * @var array<string>
	 */
	protected $fillable = ['domain_id', 'response_code', 'header', 'title', 'updated_at'];

	# get html meta data associated with this http data
	/**
	 * @return HasMany<HtmlMetaData>
	 */
	public function htmlMetaData(): HasMany{
		return $this->hasMany(HtmlMetaData::class);
	}

	# get the domain associated with this http data
	/**
	 * @return BelongsTo<Domain, HttpData>
	 */
	public function domain(): BelongsTo{
		return $this->belongsTo(Domain::class);
	}
}
