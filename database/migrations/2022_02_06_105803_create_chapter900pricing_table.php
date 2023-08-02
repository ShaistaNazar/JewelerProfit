<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter900pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter900pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('complexity')->nullable();
            $table->string('description')->nullable();
            $table->string('karats')->nullable();
            $table->string('percentage_discount_amount_of_H2')->nullable();
            $table->string('multiplied_form')->nullable();
            $table->string('welding_technology')->nullable();
            $table->string('soldering_labor_without_discount')->nullable();
            $table->string('soldering_labor_with_discount')->nullable();
            $table->string('JLRC_without_discount')->nullable();
            $table->string('JLRC_with_discount')->nullable();
            $table->string('percentage_discount_amount_of_multiplied_form')->nullable();
            $table->string('multiplication_factor_of_soldering_charge')->nullable();
            $table->string('price_criteria_item')->nullable();
            $table->string('h6')->nullable();
            $table->string('h10')->nullable();
            $table->string('note')->nullable();
            $table->boolean('orderable')->default(1);
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
        Schema::dropIfExists('chapter900pricing');
    }
}
