<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DNSRecord extends Model
{
	use HasFactory;

	protected $table = 'dns_records';
	/**
	 * @var array<int, string> $fillable
	 */
	protected $fillable = ['domain_id', 'type', 'content', 'hostname'];

	# get the domain for this dns record
	/**
	 * @return BelongsTo<Domain, DNSRecord>
	 */
	public function domain(): BelongsTo{
		return $this->belongsTo(Domain::class);
	}
}
