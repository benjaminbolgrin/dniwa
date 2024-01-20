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

	protected $fillable = ['domain_name_ascii'];
	
	# get all users associated with this domain
	public function users(): BelongsToMany{
		return $this->belongsToMany(User::class, 'user_domains', 'domain_id', 'user_id');
	}

	# get all A records for this domain
	public function dnsRecordsA(): HasMany{
		return $this->hasMany(DNSRecord::class)->where('type', 'A');
	}

	# get all MX records for this domain
	public function dnsRecordsMX(): HasMany{
		return $this->hasMany(DNSRecord::class)->where('type', 'MX');
	}

	# get http data for this domain
	public function httpRecords(): HasOne{
		return $this->hasOne(HttpData::class);
	}

	# get html meta data for this domain
	public function htmlMetaData(): HasManyThrough{
		return $this->hasManyThrough(HtmlMetaData::class, HttpData::class);
	}
}
