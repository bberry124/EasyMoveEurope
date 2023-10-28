<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    protected $table = 'refund';


    /**
     * Write code on Method
     *
     * @return response()
     */

     protected $guarded = [
        'id'
     ];
}