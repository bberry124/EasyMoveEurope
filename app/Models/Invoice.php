<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';


    /**
     * Write code on Method
     *
     * @return response()
     */

     protected $guarded = [
        'id'
     ];
}