<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter500pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter500pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('engraving_type')->nullable();
            $table->string('description',255)->nullable();
            $table->string('item_type')->nullable();
            $table->string('width')->nullable();
            $table->string('no_of_price_criteria_item')->nullable();
            $table->string('soldering_sku_per_post_or_back')->nullable(); // from 900 chapter
            $table->string('price_criteria_item')->nullable();
            $table->string('question')->nullable();
            $table->string('is_additional')->nullable();
            $table->string('retail_price')->nullable();
            $table->string('additional_lines_engraving_retail')->nullable();
            $table->string('additional_letters_over_03')->nullable();
            $table->string('additional_letters_over_08')->nullable();
            $table->string('additional_letters_over_15')->nullable();
            $table->string('JLRC_on_retail')->nullable();
            $table->string('JLRC_additional')->nullable();
            $table->string('note',255)->nullable();
            $table->string('vendor_cost_retail_price')->nullable();
            $table->string('vendor_cost_additional_lines_engraving_retail')->nullable();
            $table->string('vendor_cost_additional_letters_over_03')->nullable();
            $table->string('vendor_cost_additional_letters_over_08')->nullable();
            $table->string('vendor_cost_additional_letters_over_15')->nullable();
            $table->string('store_mark_up')->nullable();
            $table->string('shop_id')->nullable();
            $table->boolean('is_david')->nullable();
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
        Schema::dropIfExists('chapter500pricing');
    }
}