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
        Schema::create('categories_php', function (Blueprint $table) {
            $table->id();
            $table->string ('name');
            $table->string ('slug');
            $table->string ('image');
            $table->integer ('created_at');
            $table->integer ('updated_at');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('categories_php');
    }
};
