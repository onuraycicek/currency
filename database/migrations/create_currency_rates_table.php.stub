<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('from_currency_id');
            $table->integer('to_currency_id');
            $table->double('rate', 8, 3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_rates');
    }
};
