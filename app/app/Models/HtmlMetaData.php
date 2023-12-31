<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HtmlMetaData extends Model
{
    use HasFactory;
    protected $table = 'html_meta_data';
    protected $attributes = ['meta_name' => '', 'meta_charset' => '', 'meta_http_equiv' => '', 'meta_content' => '', 'meta_property' => '', 'meta_itemprop' => ''];
    protected $fillable = ['http_data_id', 'meta_name', 'meta_charset', 'meta_http_equiv', 'meta_content', 'meta_property', 'meta_itemprop'];
}
