<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'id',
        'title',
        'desc',
        'link',
        'image',
        'category',
        'created_by',
        'updated_by',
    ];
}
 