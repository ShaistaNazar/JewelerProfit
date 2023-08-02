<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvelopeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envelope_details', function (Blueprint $table) {

            $table->id();
            $table->string('envelope_id');
            $table->string('customer_number');
            $table->timestamp('take_in_date')->nullable();
            $table->string('sale_person_id')->nullable();
            $table->string('jeweler_id')->nullable();
            $table->string('location')->default('sort_box');
            $table->string('notes')->nullable()->nullable();
            $table->timestamp('expected_date')->nullable();
            $table->string('total');
            $table->string('total_with_sales_tax');
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
        Schema::dropIfExists('envelope_details');
    }
}
