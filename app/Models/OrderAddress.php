<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;


    protected $table = 'order_address';
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $guarded = [
       'id'
    ];
}
