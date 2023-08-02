<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter1100pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter1100pricing', function (Blueprint $table) {
            $table->id();
            $table->string('geller_sku');
            $table->string('retail_price');
            $table->string('optionable');
            $table->string('major_item');
            $table->string('description');
            $table->string('each_additional');
            $table->string('price_criteria_item');
            $table->string('thickness');
            $table->string('complication_surcharge');
            $table->string('part_cost_note');
            $table->string('more_percentage_to_SKU');
            $table->string('chapter1100SKUs');
            $table->string('is_estimated');
            $table->string('note');
            $table->string('note_to_show');
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
        Schema::dropIfExists('chapter1100pricing');
    }
}
