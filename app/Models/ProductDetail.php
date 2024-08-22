<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'product_details';
    protected $fillable = [
        'id',
        'title',
        'desc',
        'link',
        'category',
        'created_by',
        'updated_by',
    ];
}
