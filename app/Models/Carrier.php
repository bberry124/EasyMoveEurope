<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;
    protected $table = 'carriers';


    /**
     * Write code on Method
     *
     * @return response()
     */

 protected $fillable = [
        'carrier_name'
    ];
}