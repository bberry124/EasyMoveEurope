<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraCharges extends Model
{
    use HasFactory;
    protected $table = 'extra_charges';

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $guarded = [
        'id'
     ];
}
