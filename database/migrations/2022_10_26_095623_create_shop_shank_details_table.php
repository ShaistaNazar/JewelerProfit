<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopShankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_shank_details', function (Blueprint $table) {

            $table->id();
            $table->timestamp('latest_pricing_date')->nullable();
            $table->string('vendor_phone_number')->nullable();
            $table->string('vendor_cost_markup');
            $table->boolean('is_default')->nullable();
            $table->foreignId('shop_id')->nullable()->constrained('shops');  
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
        Schema::dropIfExists('shop_shank_details');
    }
}
