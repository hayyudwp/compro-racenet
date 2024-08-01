<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'id',
        'title',
        'date',
        'short_desc',
        'desc',
        'image',
        'category',
        'slug',
        'lang',
        'created_by',
        'updated_by',
    ];
}
