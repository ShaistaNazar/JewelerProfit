<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter600pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter600pricing', function (Blueprint $table) {
            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('stuller_sku')->nullable();
            $table->string('description')->nullable();
            $table->string('karats')->nullable();
            $table->string('shape')->nullable();
            $table->string('size')->nullable(); // from 700 chapter
            $table->string('no_of_prongs')->nullable(); // from 900 chapter
            $table->string('setting_type')->nullable();
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
        Schema::dropIfExists('chapter600pricing');
    }
}
