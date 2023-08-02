<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessStullerAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stullr_sku;
    protected $record_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stullr_sku, $record_id)
    {
        $this->stullr_sku = $stullr_sku;
        $this->record_id = $record_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Call the Stuller.com API to get the corresponding amount
        $response = file_get_contents("https://www.stuller.com/services/itemdetail/$this->stullr_sku");
        $amount = json_decode($response)->items[0]->price;

       return $amount;
    }
}
