<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalPrice extends Model
{
    use HasFactory;
    protected $table = 'prices';

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $guarded = [
        'id'
     ];
}
