<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HtmlMetaData extends Model
{
	use HasFactory;

	protected $table = 'html_meta_data';
	/**
	 * @var array<string, string>
	 */
	protected $attributes = ['meta_name' => '', 'meta_charset' => '', 'meta_http_equiv' => '', 'meta_content' => '', 'meta_property' => '', 'meta_itemprop' => ''];
	/**
	 * @var array<string>
	 */
	protected $fillable = ['http_data_id', 'meta_name', 'meta_charset', 'meta_http_equiv', 'meta_content', 'meta_property', 'meta_itemprop'];

	# get http data associated with this html meta data
	/**
	 * @return BelongsTo<HttpData, HtmlMetaData>
	 */
	public function httpData(): BelongsTo{
		return $this->belongsTo(HttpData::class);
	}
}
