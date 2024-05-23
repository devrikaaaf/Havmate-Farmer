<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate_Distributor extends Model
{
    public $table = 'coordinate_distributor';

    protected $fillable = [
        
        'latitude',
        'longitude'
        
    ];
}

