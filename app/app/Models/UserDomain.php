<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDomain extends Model
{
    use HasFactory;
    protected $table = 'user_domains';
    protected $fillable = ['user_id', 'domain_id'];
}
