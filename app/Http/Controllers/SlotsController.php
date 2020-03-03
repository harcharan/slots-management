<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slot;
use Redirect;
use Carbon\Carbon;

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

        $data['date'] = Carbon::createFromFormat('m-d-Y', $data['date'])->format('Y-m-d');
        
        Slot::create($data);
    
        return Redirect::to('slots')->with('success', 'Slot added successfully.');
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
            'title' => 'required',
            'product_code' => 'required',
            'description' => 'required',
        ]);
         
        $data = ['title' => $request->title, 'description' => $request->description];
        Slot::where('id', $id)->update($data);
   
        return Redirect::to('slots')->with('success', 'Slot updated successfully.');
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
}
