<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    use HasFactory;
    protected $table = 'credit_note';


    /**
     * Write code on Method
     *
     * @return response()
     */

     protected $guarded = [
        'id'
     ];
}