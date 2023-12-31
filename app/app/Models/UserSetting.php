<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;
    protected $attributes = [

	    'theme' => 'light'
    ];

    protected $fillable = [
	    'user_id'
    ];
}
