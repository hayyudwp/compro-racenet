<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutRN extends Model
{
    use HasFactory;

    protected $table = 'abouts';
    protected $fillable = [
        'id',
        'title',
        'desc',
        'link_icon',
        'created_by',
        'updated_by',
    ];
}
