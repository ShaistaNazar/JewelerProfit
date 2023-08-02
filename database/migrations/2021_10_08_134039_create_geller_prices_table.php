<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGellerPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geller_prices', function (Blueprint $table) {

            $table->id();
            $table->string('sku');
            $table->string('name');
            $table->string('size');
            $table->string('karat_and_color');
            $table->string('item_stuller');
            $table->string('labor');
            $table->string('no_of_jump_rings');
            $table->string('jump_rings_stuller');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geller_prices');
    }
}
