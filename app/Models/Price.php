<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    static $status = [
        'WAITING PAYMENT' => 'WAITING PAYMENT',
        'PAID' => 'PAID', 'CONFIRMED' => 'CONFIRMED', 'DEFERRED PAYMENT' => 'DEFERRED PAYMENT', 'CANCELLED BEFORE PAYMENT' => 'CANCELLED BEFORE PAYMENT', 'CANCELLED AFTER PAYMENT' => 'CANCELLED AFTER PAYMENT'];

    protected $table = 'requests';
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $guarded = [
       'id'
    ];
}
