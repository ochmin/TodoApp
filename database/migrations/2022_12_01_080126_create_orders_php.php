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
        Schema::create('orders_php', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->float('total_price');
            $table->string('invoice_number');
            $table->enum('status',['SUBMIT', 'PROCESS', 'FINISH', 'CANCEL']);
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
        Schema::dropIfExists('orders_php');
    }
};
