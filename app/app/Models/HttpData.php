<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HttpData extends Model
{
    use HasFactory;
    protected $table = 'http_data';
    protected $attributes = ['title' => ''];
    protected $fillable = ['domain_id', 'response_code', 'header', 'title', 'updated_at'];
}
