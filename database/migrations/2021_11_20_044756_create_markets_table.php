<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('Name')->nullable();
            $table->string('Owner')->nullable();
            $table->string('Description')->nullable();
            $table->string('Tags')->nullable();
            $table->string('address')->nullable();
            $table->string('Category')->nullable();
            $table->string('Score')->nullable();
            $table->string('Email')->nullable();
            $table->string('Status')->default('Available');
            $table->string('user_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('visits')->nullable();
            $table->string('most_visits')->nullable();
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
        Schema::dropIfExists('markets');
    }
}
