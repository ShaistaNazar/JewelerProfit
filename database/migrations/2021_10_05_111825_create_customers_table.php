<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('spouce_f_name')->nullable();
            $table->string('spouce_l_name')->nullable();
            $table->string('customer_id')->unique();
            $table->string('gender');
            $table->date('birth_date');
            $table->string('cell_phone');
            $table->string('alternative')->nullable();
            $table->boolean('should_contact')->default(true);
            $table->string('email')->unique();
            $table->string('street_address')->nullable();
            $table->string('apartment')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable()->constrained('shops');
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
        Schema::dropIfExists('customers');
    }
}
