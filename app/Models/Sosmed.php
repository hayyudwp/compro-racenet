<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sosmed extends Model
{
    use HasFactory;

    protected $table = 'sosmeds';
    protected $fillable = [
        'id',
        'title',
        'code_icon',
        'link',
        'created_by',
        'updated_by',
    ];
}
