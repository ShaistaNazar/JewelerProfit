<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter1200pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter1200pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('retail_price')->nullable();
            $table->string('optionable')->nullable();
            $table->string('extra_work_per_appraisal')->nullable();
            $table->string('minimum_no_of_items_to_charge')->nullable();
            $table->string('question')->nullable();
            $table->string('welding_technology')->nullable();
            $table->string('interlinked_option')->nullable();
            $table->string('required_interlink_quantity')->nullable();
            $table->string('conditional_stuller_sku')->nullable();
            $table->string('type')->nullable();
            $table->string('quantity')->nullable();
            $table->string('each_additional')->nullable();
            $table->string('vendor_cost')->nullable();
            $table->string('no_of_price_criterian_item')->nullable();
            $table->string('price_criteria_item')->nullable();
            $table->string('first_service')->nullable();
            $table->string('description')->nullable();
            $table->string('info_popup')->nullable();
            $table->string('price_criterian_item')->nullable();
            $table->string('orderable')->nullable();
            $table->string('size')->nullable();
            $table->string('karats')->nullable();
            $table->string('color')->nullable();
            $table->string('stuller_sku')->nullable();
            $table->string('flat_fee')->nullble();
            $table->string('minimum_quantity')->nullble();
            $table->string('no_of_price_criteria_item')->nullble();
            $table->string('service_type')->nullble();
            $table->string('part_cost_note')->nullable();
            $table->string('soldering_sku')->nullable();
            $table->string('setting_sku')->nullable();
            $table->string('chapter1200SKUs')->nullable();
            $table->string('qty_to_solder')->nullable();
            $table->string('stuller_additional_part_1')->nullable();
            $table->string('qty_of_additional_part_1')->nullable();
            $table->string('stuller_additional_part_2')->nullable();
            $table->string('qty_of_additional_part_2')->nullable();
            $table->string('dependent_part_stuller_if_needed')->nullable();
            $table->string('note')->nullable();
            $table->string('sizing_stock_amount')->nullable();
            $table->string('handmade_piece_weight_14kt')->nullable();
            $table->string('handmade_piece_weight_18kt')->nullable();
            $table->string('picklist_item_if_needed')->nullable();
            $table->string('picklist_quantity_if_needed')->nullable();
            $table->string('picklist_stuller_if_needed')->nullable();
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
        Schema::dropIfExists('chapter1200pricing');
    }
}
