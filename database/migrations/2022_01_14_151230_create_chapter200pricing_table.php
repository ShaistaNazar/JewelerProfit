<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter200pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter200pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('type')->nullable();
            $table->string('karats')->nullable();
            $table->string('image')->nullable();
            $table->string('no_of_price_criteria_item')->nullable();
            $table->string('price_criteria_item')->nullable();
            $table->string('JLRC_labor_torch')->nullable();
            $table->string('JLRC_labor_laser')->nullable();
            $table->string('stuller_sku')->nullable();
            $table->string('stuller_part_item_if_needed')->nullable(); 
            $table->string('part_cost_note')->nullable();   
            $table->string('note')->nullable();
            $table->string('orderable')->nullable();
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
        Schema::dropIfExists('chapter200pricing');
    }
}
