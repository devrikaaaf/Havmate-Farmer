<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate_Farmer extends Model
{
    public $table = 'coordinate_farmer';

    protected $fillable = [
        
        'latitude',
        'longitude'
        
    ];
}
