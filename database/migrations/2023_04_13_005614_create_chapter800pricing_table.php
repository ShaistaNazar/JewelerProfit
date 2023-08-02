<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter800pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter800pricing', function (Blueprint $table) {
            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('type')->nullable();
            $table->string('inside_diameter')->nullable();
            $table->string('size')->nullable();
            $table->string('description')->nullable();
            $table->string('shape')->nullable();
            $table->string('karats')->nullable();
            $table->string('color')->nullable();
            $table->string('stuller_sku')->nullable();
            $table->string('soldering_sku')->nullable();
            $table->string('setting_sku')->nullable();
            $table->string('note')->nullable();
            $table->string('shop_id')->nullable();
            $table->boolean('is_david')->nullable();
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
        Schema::dropIfExists('chapter800pricing');
    }
}
