<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsInOurCareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_in_our_care', function (Blueprint $table) {

            $table->id();
            $table->longText('item_description');
            $table->string('repair_id');
            $table->string('customer_stated_value')->nullable();
            $table->string('photos')->nullable();
            $table->longText('stones_quality_description')->nullable();
            $table->longText('stones_guarrantee_description')->nullable();
            $table->boolean('is_guarranteed')->nullable();
            $table->string('envelope_id');
            $table->timestamp('completion_date');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade');
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
        Schema::dropIfExists('items_in_our_care');
    }
}
