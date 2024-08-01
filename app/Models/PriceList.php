<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    use HasFactory;
    protected $table = 'pricelists';
    protected $fillable = [
        'id',
        'title',
        'bandwith',
        'price',
        'desc',
        'category',
        'created_by',
        'updated_by',
    ];
}
