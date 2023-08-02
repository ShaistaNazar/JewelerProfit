<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_details', function (Blueprint $table) {
            
            // some dat would be imported from client databases 
            $table->id();
            $table->string('torch_or_laser');
            $table->string('color');
            $table->string('mark');
            $table->string('size_to_change_to');
            $table->string('size_now');
            $table->string('size_to');
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
        Schema::dropIfExists('jewel_jobs');
    }
}
