<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter700pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter700pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku');
            $table->string('item_description')->nullable();
            $table->string('setting_type')->nullable();
            $table->string('major_item')->nullable();
            $table->string('item_type')->nullable();
            $table->string('no_of_price_criteria_item')->nullable();
            $table->string('price_criteria_item')->nullable();
            $table->string('carats')->nullable();
            $table->string('stone_size')->nullable();
            $table->string('size')->nullable();
            $table->string('setting_labor_without_discount')->nullable();
            $table->string('h6_multiplication_factor')->nullable();
            $table->string('JLRC_without_discount')->nullable();
            $table->string('setting_labor_with_discount')->nullable();
            $table->string('JLRC_with_discount')->nullable();
            $table->boolean('is_flat_fee');
            $table->string('discount_applying')->nullable();
            $table->string('previous_dependency')->nullable();
            $table->string('multiplied_form')->nullable();
            $table->string('h6')->nullable();
            $table->string('note')->nullable();
            $table->boolean('orderable')->nullable();
            $table->string('shop_id')->nullable();
            $table->string('is_master')->nullable();
            $table->string('main_dependency_sku')->nullable();
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
        Schema::dropIfExists('chapter700pricing');
    }
}
