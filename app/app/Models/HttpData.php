<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HttpData extends Model
{
    use HasFactory;
    protected $table = 'http_data';
    protected $fillable = ['response_code', 'header', 'title'];
}
