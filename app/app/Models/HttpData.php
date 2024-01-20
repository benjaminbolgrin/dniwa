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
	protected $attributes = ['title' => ''];
	protected $fillable = ['domain_id', 'response_code', 'header', 'title', 'updated_at'];

	# get html meta data associated with this http data
	public function htmlMetaData(): HasMany{
		return $this->hasMany(HtmlMetaData::class);
	}

	# get the domain associated with this http data
	public function domain(): BelongsTo{
		return $this->belongsTo(Domain::class);
	}
}
