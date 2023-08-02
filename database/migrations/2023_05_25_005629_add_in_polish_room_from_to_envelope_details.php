<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInPolishRoomFromToEnvelopeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('envelope_details', function (Blueprint $table) {

            $table->string('in_polish_room_from')->nullable();
            $table->string('in_cad_wax_from')->nullable();
            $table->string('in_appraiser_from')->nullable();
            $table->string('polish_completed')->nullable();
            $table->string('hold_completed')->nullable();
            $table->string('order_completed')->nullable();
            $table->string('appraiser_completed')->nullable();
            $table->string('wax_completed')->nullable();
            $table->string('assign_to_jeweler_from')->nullable();
            $table->string('placed_order_date')->nullable();
            $table->string('jeweler_work_completed')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('envelope_details', function (Blueprint $table) {
            //
        });
    }
}
