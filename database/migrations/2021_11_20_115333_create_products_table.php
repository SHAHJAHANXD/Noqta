<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('Name')->nullable();
            $table->string('Description')->nullable();
            $table->string('Tags')->nullable();
            $table->string('Score')->nullable();
            $table->string('MarketNameForProduct')->nullable();
            $table->string('Status')->default('Available');
            $table->string('Price')->nullable();
            $table->string('Rating')->nullable();
            $table->string('Reviews')->nullable();
            $table->string('Location')->nullable();
            $table->string('Category')->nullable();
            $table->string('user_id')->nullable();
            $table->string('market_id')->nullable();
            $table->string('Release_date')->nullable();
            $table->string('Expiry_date')->nullable();
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
        Schema::dropIfExists('products');
    }
}
