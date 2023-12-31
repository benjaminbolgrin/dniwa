<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DNSRecord extends Model
{
    use HasFactory;
    protected $table = 'dns_records';
    protected $fillable = ['domain_id', 'type', 'content', 'hostname'];
}
