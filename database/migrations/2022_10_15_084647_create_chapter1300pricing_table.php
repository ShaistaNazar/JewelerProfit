<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapter1300pricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter1300pricing', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku');
            $table->string('major_item')->nullable();
            $table->string('stuller_sku')->nullable();
            $table->string('type')->nullable();
            $table->string('shape')->nullable();
            $table->string('description')->nullable();
            $table->string('color')->nullable();
            $table->string('carats')->nullable();
            $table->string('diamond_grade')->nullable();
            $table->string('size')->nullable();
            $table->string('cut')->nullable();
            $table->string('quality')->nullable();
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
        Schema::dropIfExists('chapter1300pricing');
    }
}
