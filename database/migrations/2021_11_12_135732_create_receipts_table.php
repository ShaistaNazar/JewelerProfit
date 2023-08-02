<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->enum('receipt_type',['repair','paid']);
            $table->foreignId('jeweler_id')->nullable()->constrained('users');
            $table->foreignId('customer_no')->nullable()->constrained('users');
            $table->foreignId('envelope_no');
            $table->json('job_ids');
            $table->string('grand_total')->nullable();
            $table->string('total_with_tax');
            $table->string('payment_method')->nullable();
            $table->string('picked_by')->nullable();
            $table->foreignId('assisted_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('receipts');
    }
}
