<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'service', 'detail',
    ];
}
