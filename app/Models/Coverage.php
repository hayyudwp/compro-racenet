<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coverage extends Model
{
    use HasFactory;

    protected $table = 'coverages';
    protected $fillable = [
        'id',
        'area',
        'code_map',
        'district'
    ];
}
