<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter100pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter100pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku')->nullable();
            $table->string('dependency_criteria')->nullable();
            $table->string('formula')->nullable();
            $table->string('main_dependency_sku')->nullable();
            $table->string('main_dependency_upon')->nullable();
            $table->string('main_dependency_multiplier')->nullable();
            $table->string('main_dependency_title')->nullable();
            $table->string('other_dependency_sku')->nullable();
            $table->string('other_dependency_title')->nullable();
            $table->string('other_dependency_upon')->nullable();
            $table->string('other_dependency_multiplier')->nullable();
            $table->string('retail_price')->nullable();
            $table->string('price')->nullable();
            $table->string('JLRC')->nullable();
            $table->string('major_item')->nullable();
            $table->string('type')->nullable();
            $table->string('chapter1200SKUs')->nullable();
            $table->string('description')->nullable();
            $table->string('shape')->nullable();
            $table->string('karats')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('welding_technology')->nullable();
            $table->string('width')->nullable();
            $table->string('weight')->nullable();
            $table->string('smaller_or_larger')->nullable();
            $table->string('column_value')->nullable();
            $table->string('dependent_column')->nullable();
            $table->string('multiplier')->nullable();
            $table->string('sku_dependencies')->nullable();
            $table->string('chapter700')->nullable();
            $table->string('stone_size')->nullable();
            $table->string('silver_stone_specification')->nullable();
            $table->string('formula_for_first_size_larger');
            $table->string('first_size_larger')->nullable();
            $table->string('each_additional_size_JLRC')->nullable();
            $table->json('stuller_sku_for_metal_pricing_for_each_size_larger')->nullable();
            $table->string('part_cost_note')->nullable();
            $table->string('outside_vendor_cost')->nullable();
            $table->string('superfit_cost_of_jlrc_installation')->nullable();
            $table->string('vendor_markup_for_part_geller_book_retail')->nullable();
            $table->string('markup_for_superfit_labor_to_install')->nullable();
            $table->string('part_markup')->nullable();
            $table->string('shop_id')->nullable();
            $table->string('is_master')->nullable();
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
        Schema::dropIfExists('chapter100pricing');
    }
}
