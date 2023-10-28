<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('reg_number');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('garage');
            $table->string('seller_phone');
            $table->string('date');
            $table->string('location');
            $table->string('prefer_time');
            $table->string('inspection');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
