<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter1000pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter1000pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku')->nullable();
            $table->string('multiplier_of_master_price')->nullable();
            $table->string('master_applicable')->nullable();
            $table->string('retail_labor')->nullable();
            $table->string('major_item')->nullable();
            $table->string('type')->nullable();
            $table->string('length_of_chain')->nullable();
            $table->string('who_keeps_mold')->nullable();
            $table->string('way_around')->nullable();
            $table->string('stone_details')->nullable();
            $table->string('exchange_details')->nullable();
            $table->string('part_specifications')->nullable();
            $table->string('cast_into')->nullable();
            $table->string('price_criteria_item')->nullable();
            $table->string('dependent_chapter_specifications')->nullable();
            $table->string('dependent_chapter')->nullable();
            $table->string('area_details')->nullable();
            $table->string('description')->nullable();
            $table->string('labor_only')->nullable();
            $table->string('karats')->nullable();
            $table->string('shop_input_quantity_for_pricing')->nullable();
            $table->string('metal_weight')->nullable();
            $table->string('chapter700')->nullable();
            $table->string('require_weight_popup')->nullable();
            $table->string('stuller_sku')->nullable();
            $table->string('stuller_quantity')->nullable();
            $table->string('orderable')->nullable();
            $table->string('note')->nullable();
            $table->string('popup')->nullable();
            $table->string('extra_note1')->nullable();
            $table->string('extra_note2')->nullable();
            $table->string('extra_note3')->nullable();

            $table->string('shop_id')->nullable();
            $table->string('is_master')->nullable();
            $table->string('main_dependency_sku')->nullable();
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
        Schema::dropIfExists('chapter1000pricing');
    }
}
