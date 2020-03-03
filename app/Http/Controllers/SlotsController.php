<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slot;
use Redirect;

class SlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['slots'] = Slot::orderBy('id', 'desc')->paginate(10);
        return view('slots.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        $data = $request->all();

        $data['date'] = date("Y-m-d", strtotime($data['date']));
        $data['start'] = date("H:i", strtotime($data['start']));
        $data['end'] = date("H:i", strtotime($data['end']));
        
        $status = 'success';
        $message = 'Slot added successfully.';
        try {
            Slot::create($data);
        } catch (\Exception $ex) {
            $status = 'error';
            $message = 'Something went wrong. Please try again.';
        }
    
        return Redirect::to('slots')->with($status, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['slot_info'] = Slot::where('id', $id)->first();
        return view('slots.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        $data = array();

        $data['date'] = date("Y-m-d", strtotime($request->date));
        $data['start'] = date("H:i", strtotime($request->start));
        $data['end'] = date("H:i", strtotime($request->end));
        
        $status = 'success';
        $message = 'Slot updated successfully.';
        try {
            Slot::where('id', $id)->update($data);
        } catch (\Exception $ex) {
            $status = 'error';
            $message = 'Something went wrong. Please try again.';
        }
   
        return Redirect::to('slots')->with($status, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Slot::where('id', $id)->delete();
        return Redirect::to('slots')->with('success', 'Slot deleted successfully.');
    }

    /*
     * Check slot exists
     */
    public function checkSlot(Request $request) {
        $date = date("Y-m-d", strtotime($request->date));
        $start = date("H:i:s", strtotime($request->start));
        $end = date("H:i:s", strtotime($request->end));

        $slotAvailability = Slot::where('date', $date)
        ->where(function ($query) use ($start, $end) { 
            $query
            ->where(function ($query) use ($start, $end) {
                $query
                    ->where('start', '<=', $start)
                    ->where('end', '>', $start);
            })
            ->orWhere(function ($query) use ($start, $end) {
                $query
                    ->where('start', '<', $end)
                    ->where('end', '>=', $end);
            });
        })->count();

        return $slotAvailability;
    }

}
