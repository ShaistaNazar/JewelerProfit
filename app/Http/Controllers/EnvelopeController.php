<?php

namespace App\Http\Controllers;

use App\Models\EnvelopeDetail;
use App\Models\JobHistory;
use App\Models\User;
use Illuminate\Http\Request;

class EnvelopeController extends Controller
{
    public function addEnvelopeDetails(Request $request )
    {
        # code...
        $envelope = EnvelopeDetail::updateOrCreate(
            [   'envelope_id'     => $request->envelope_id  ],
            [
                'location'        => 'sort_box',
                'expected_date'   => \Carbon\Carbon::now()->toDateTimeString(),
                'jeweler_id'      => null,
                'customer_number' => $request->customer_number,
                'take_in_date'    => \Carbon\Carbon::now()->toDateTimeString(),
                'sale_person_id'  => $request->sale_person_id,
                'notes'           => $request->notes,
                'total'           => $request->total,
                'total_with_sales_tax'           => $request->total_with_sales_tax,
            ]
        );
        return $this->APIResponse(config('response_codes.OK'), 'Envelope created for sort box.',$envelope);
    }

    public function getSortBox(Request $request)
    {
        $query_params = request()->filter;

        if($query_params && $query_params !== '')
        {
            $details = EnvelopeDetail::where('location','sort_box')
            ->WhereRaw("REPLACE(envelope_id, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
            ->with('sort_box_job_history','jeweler','sale_person')->paginate(10);
        }
        else
        {
            $details =   EnvelopeDetail::where('location','sort_box')->with('sort_box_job_history','jeweler','sale_person')->paginate(10);
        }

        return $this->APIResponse(config('response_codes.OK'), 'sort box returned successfully',array('details'=>$details));
              
    }

    public function getJewelerBox()
    {
        # code...
        // $data = EnvelopeDetail::whereNull('location')->whereNotNull('jeweler_id')->with('sort_box_job_history','jeweler','sale_person')->paginate(10);
        
        $query_params = request()->filter;

        if($query_params && $query_params !== '')
        {
            $details = EnvelopeDetail::where('location','jeweler_box')
            ->WhereRaw("REPLACE(envelope_id, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
            ->with('sort_box_job_history','jeweler','sale_person')->paginate(10);
        }
        else
        {
            $details = EnvelopeDetail::where('location','jeweler_box')
            ->with('sort_box_job_history', 'jeweler', 'sale_person')
            ->paginate(10);;
        }

        return $this->APIResponse(config('response_codes.OK'), 'sort box returned successfully',array('details'=>$details));
    }

    public function getOrderBox(Request $request)
    {

        $query_params = request()->filter;
        if($query_params && $query_params !== '')
        {
            $data = EnvelopeDetail::where('location', 'order_box')
            ->WhereRaw("REPLACE(envelope_id, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
            
            ->with('sort_box_job_history', 'jeweler', 'sale_person','vendor')
            ->paginate(10);
        }
        else
        {
            $data = EnvelopeDetail::where('location', 'order_box')
            ->with('sort_box_job_history', 'jeweler', 'sale_person','vendor')
            ->paginate(10);
        }
        return $this->APIResponse(config('response_codes.OK'), 'order box returned successfully',array('details'=>$data));
    }

    public function getHoldBox(Request $request)
    {
        $query_params = request()->filter;
        if($query_params && $query_params !== '')
        {
            $data = EnvelopeDetail::where('location', 'hold_box')
                ->WhereRaw("REPLACE(envelope_id, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(10);
        }
        else
        {
            $data = EnvelopeDetail::where('location', 'hold_box')
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(10);
        }

        return $this->APIResponse(config('response_codes.OK'), 'sort box returned successfully',array('details'=>$data));

    }

    public function getFinishedBox(Request $request)
    {
        $query_params = request()->filter;
        if($query_params && $query_params !== '')
        {
            $data = EnvelopeDetail::where('location', 'finished_box')
                ->WhereRaw("REPLACE(envelope_id, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(2);
        }
        else
        {
            $data = EnvelopeDetail::where('location', 'finished_box')
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(2);
        }

        return $this->APIResponse(config('response_codes.OK'), 'sort box returned successfully',array('details'=> $data));

    }
    public function getPolishRoom(Request $request)
    {
        $query_params = request()->filter;
        if($query_params && $query_params !== '')
        {
            $data = EnvelopeDetail::where('location', 'polish')
                ->WhereRaw("REPLACE(envelope_id, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(10);
        }
        else
        {
            $data = EnvelopeDetail::where('location', 'polish')
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(10);
        }
        return $this->APIResponse(config('response_codes.OK'), 'sort box returned successfully',array('details'=>$data));

    }
    public function getCadWaxerBox(Request $request)
    {
        $query_params = request()->filter;
        if($query_params && $query_params !== '')
        {
            $data = EnvelopeDetail::where('location', 'cad_waxer')
                ->WhereRaw("REPLACE(envelope_id, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(10);
        }
        else
        {
            $data = EnvelopeDetail::where('location', 'cad_waxer')
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(10);
        }
        return $this->APIResponse(config('response_codes.OK'), 'sort box returned successfully',array('details'=>$data));

    }public function getAppraiserBox(Request $request)
    {

        $query_params = request()->filter;
        if($query_params && $query_params !== '')
        {
            $data = EnvelopeDetail::where('location', 'appraiser')
                ->WhereRaw("REPLACE(envelope_id, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(10);
        }
        else
        {
            $data = EnvelopeDetail::where('location', 'appraiser')
                
                ->with('sort_box_job_history', 'jeweler', 'sale_person')
                ->paginate(10);
        }
        return $this->APIResponse(config('response_codes.OK'), 'sort box returned successfully',array('details'=>$data));
 
    }

    public function moveEnvelopeToLocation(Request $request)
    {
        // dd($request->all());
        // JobHistory::whereIn('envelope_id',$request->envelope_ids)->update(['location'=>$request->selected_location]);
        if($request->selected_location)
        {
            foreach ($request->envelope_ids as $envelope_id) 
            {

                $envelope_detail = EnvelopeDetail::where('envelope_id',$envelope_id)->first();
                $envelope_detail->location = $request->selected_location;
                $envelope_detail->jeweler_id = null;
                if(isset($request->envelope_notes) && $request->envelope_notes !== '')
                {
                    $envelope_detail->notes = $request->envelope_notes;
                }
                if($request->selected_location == 'order_box')
                {
                    $envelope_detail->vendor_id = $request->selected_vendor;
                    $envelope_detail->placed_order_date = \Carbon\Carbon::now()->toDateString();
                    $envelope_detail->arrival_date = \Carbon\Carbon::parse($request->arrival_date)
                    ->toDateString();
                }
                if($request->selected_location == 'hold_box')
                {
                    $envelope_detail->hold_from_date = \Carbon\Carbon::now()->toDateString();
                }
                if($request->selected_location == 'finished_box')
                {
                    $envelope_detail->completion_date = \Carbon\Carbon::parse($request->finished_date)->toDateString();
                }
                if($request->selected_location == 'polish_room')
                {
                    $envelope_detail->in_polish_room_from = \Carbon\Carbon::now()->toDateString();
                }
                if($request->selected_location == 'cad_wax')
                {
                    $envelope_detail->in_cad_wax_from = \Carbon\Carbon::now()->toDateString();
                }
                if($request->selected_location == 'appraiser')
                {
                    $envelope_detail->in_appraiser_from = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'hold_box')
                {
                    $envelope_detail->hold_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'order_box')
                {
                    $envelope_detail->order_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'polish_room')
                {
                    $envelope_detail->polish_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'cad_wax')
                {
                    $envelope_detail->wax_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'appraiser')
                {
                    $envelope_detail->appraiser_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'jeweler_box')
                {
                    $envelope_detail->jeweler_work_completed = \Carbon\Carbon::now()->toDateString();
                }
                $envelope_detail->save();
            }
        }
        else if($request->jeweler_id)
        {
            foreach ($request->envelope_ids as $envelope_id) {

                $envelope_detail = EnvelopeDetail::where('envelope_id',$envelope_id)->first();
                $envelope_detail->jeweler_id = $request->jeweler_id;
                $envelope_detail->location = null;
                $envelope_detail->assign_to_jeweler_from = \Carbon\Carbon::now()->toDateString();
                $envelope_detail->expected_from_jeweler = \Carbon\Carbon::parse($request->expected_from_jeweler)->toDateString();
                $envelope_detail->notes = $request->envelope_notes;

                if($request->from_location == 'hold_box')
                {
                    $envelope_detail->hold_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'order_box')
                {
                    $envelope_detail->order_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'polish_room')
                {
                    $envelope_detail->polish_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'cad_wax')
                {
                    $envelope_detail->wax_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'appraiser')
                {
                    $envelope_detail->appraiser_completed = \Carbon\Carbon::now()->toDateString();
                }
                if($request->from_location == 'jeweler_box')
                {
                    $envelope_detail->jeweler_work_completed = \Carbon\Carbon::now()->toDateString();
                }
                $envelope_detail->save();

            }
        }

        return $this->APIResponse(config('response_codes.OK'), 'Envelopes Are moved');
    }
}
