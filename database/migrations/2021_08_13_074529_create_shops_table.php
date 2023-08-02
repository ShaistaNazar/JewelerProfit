<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {

            $table->id();
            $table->string('shop_name');
            $table->boolean('have_laser')->default(0);
            $table->boolean('ever_used_laser')->default(0);
            $table->string('street_address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('apartment')->nullable();
            $table->string('contact_no')->nullable();
            $table->foreignId('owner_id')->unique()->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('is_branch')->nullable();
            $table->boolean('is_main')->default(1);
            $table->string('trademark_url');
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
        Schema::dropIfExists('shops');
    }
}
