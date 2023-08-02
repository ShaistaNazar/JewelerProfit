<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_histories', function (Blueprint $table) {

            $table->id();
            $table->string('geller_sku');
            $table->string('grand_total');
            $table->string('sales_tax')->nullable();
            $table->string('service_id')->nullable();
            $table->boolean('is_rush')->nullable();
            $table->boolean('is_rhodium')->nullable();
            $table->string('total_with_labor_and_part');
            $table->string('picklist_charges')->nullable();
            $table->string('express_total')->nullable();
            $table->string('other_charges')->nullable();
            $table->string('rhodium_charges')->nullable();
            $table->string('rush_service')->nullable();
            $table->enum('status', ['pending', 'delayed','completed','delivered'])->default('pending');
            $table->timestamp('placed_at');
            // desired date is promise date that we are asking from sale person while repairing
            $table->timestamp('desired_at');
            $table->timestamp('completed_at');
            $table->timestamp('delivered_at');
            $table->timestamp('setting_charges');
            $table->timestamp('soldering_charges');
            $table->json('price_chart')->nullable();
            $table->foreignId('items_in_our_care_id')->nullable();
            $table->string('part_cost')->nullable();
            $table->string('part_retail')->nullable();
            $table->string('labor_cost')->nullable();
            $table->string('labor_retail');
            $table->string('total_cost')->nullable();
            $table->string('total_retail')->nullable();
            $table->string('sale_person_performed_job')->nullable();
            $table->string('other_cost')->nullable();
            $table->string('other_note')->nullable();
            $table->string('other_retail')->nullable();
            $table->json('pick_list_charges')->nullable();
            $table->string('total_with_sales_tax');
            $table->foreignId('jeweler_id')->nullable()->constrained('users');
            $table->foreignId('sale_person_id')->nullable()->constrained('users');
            
            $table->string('envelope_id')->nullable();
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
        Schema::dropIfExists('job_histories');
    }
}
