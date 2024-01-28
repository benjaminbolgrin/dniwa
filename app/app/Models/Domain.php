<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Domain extends Model
{
	use HasFactory;

	/*
	 * @var array<int, string> $fillable
	 */
	protected $fillable = ['domain_name_ascii'];
	
	# get all users associated with this domain
	/**
	 * @return BelongsToMany<User>
	 */
	public function users(): BelongsToMany{
		return $this->belongsToMany(User::class, 'user_domains', 'domain_id', 'user_id');
	}

	# get all dns records
	/**
	 * @return HasMany<DNSRecord>
	 */
	public function dnsRecords(): HasMany{
		return $this->hasMany(DNSRecord::class);
	}

	# get all A records for this domain
	/**
	 * @return HasMany<DNSRecord>
	 */
	public function dnsRecordsA(): HasMany{
		return $this->hasMany(DNSRecord::class)->where('type', 'A');
	}

	# get all MX records for this domain
	/**
	 * @return HasMany<DNSRecord>
	 */
	public function dnsRecordsMX(): HasMany{
		return $this->hasMany(DNSRecord::class)->where('type', 'MX');
	}

	# get http data for this domain
	/**
	 * @return HasOne<HttpData>
	 */
	public function httpData(): HasOne{
		return $this->hasOne(HttpData::class);
	}

	# get html meta data for this domain
	/**
	 * @return HasManyThrough<HtmlMetaData>
	 */
	public function htmlMetaData(): HasManyThrough{
		return $this->hasManyThrough(HtmlMetaData::class, HttpData::class);
	}
}
