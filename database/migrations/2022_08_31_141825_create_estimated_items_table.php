<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimated_items', function (Blueprint $table) {

            $table->id();
            $table->string('service_id');
            $table->string('envelope_id');
            $table->string('geller_sku');
            $table->foreignId('vendor_id')->constrained('users');
            $table->foreignId('shop_id')->constrained('shops');
            $table->string('customer_number');
            $table->foreign('customer_number')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->timestamp('date_sent');
            $table->timestamp('date_received_back_into_store')->nullable();
            $table->string('estimated_cost_from');
            $table->string('estimated_cost_to')->nullable();
            $table->string('estimated_cost_finalized')->nullable();
            $table->string('retail_price')->nullable();
            $table->string('is_rush')->nullable();
            $table->longText('work_to_be_performed');
            $table->boolean('customer_approved_or_declined')->nullable();
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
        Schema::dropIfExists('estimated_items');
    }
}
