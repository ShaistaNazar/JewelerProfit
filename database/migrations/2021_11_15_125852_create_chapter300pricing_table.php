<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter300pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter300pricing', function (Blueprint $table) {
            
            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('optionable')->nullable();
            $table->string('size')->nullable();
            $table->string('karats')->nullable();
            $table->string('stuller_sku')->nullable();
            $table->string('part_cost_note')->nullable();
            $table->string('JLRC_labor_torch')->nullable();
            $table->string('JLRC_labor_laser')->nullable();
            $table->string('ask_furthur')->nullable();
            $table->string('ask_furthur_skus')->nullable();
            $table->string('dependent_parts_if_needed')->nullable();
            $table->string('dependent_part_quantity_if_needed')->nullable();
            $table->string('dependent_part_stuller_if_needed')->nullable();
            $table->string('note')->nullable();
            $table->string('dependent_part_skus')->nullable();
            $table->string('picklist_item_if_needed')->nullable();
            $table->string('comparative_percentage_to_sku')->nullable();
            $table->string('picklist_quantity_if_needed')->nullable();
            $table->string('picklist_stuller_if_needed')->nullable();
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
        Schema::dropIfExists('chapter300pricing');
    }
}
