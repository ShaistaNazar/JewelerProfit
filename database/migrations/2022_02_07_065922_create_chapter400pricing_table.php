<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter400pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter400pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('type')->nullable();
            $table->string('stone_shape')->nullable();
            $table->string('stone_size')->nullable();
            $table->string('Karats')->nullable();
            $table->string('setting_sku')->nullable(); // from 700 chapter
            $table->string('soldering_sku_per_post_or_back')->nullable(); // from 900 chapter
            $table->string('stuller_sku')->nullable();
            $table->string('qty_to_order_of_stuller_sku')->nullable();
            $table->string('part_cost_note')->nullable();
            $table->string('JLRC_labor_torch')->nullable();
            $table->string('JLRC_labor_laser')->nullable();
            $table->string('picklist_item_if_needed')->nullable();
            $table->string('picklist_quantity_if_needed')->nullable();
            $table->string('picklist_stuller_if_needed')->nullable();
            $table->boolean('note')->nullable();
            $table->boolean('dependent_part_skus')->nullable();
            $table->boolean('comparative_percentage_to_sku')->nullable();
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
        Schema::dropIfExists('chapter400pricing');
    }
}
