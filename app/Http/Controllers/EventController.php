<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventMaster;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = EventMaster::get();
        return view("event.index")->with("events", $events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $rules = [
            "event_name"=>"required|max:255|unique:event_masters",
            "venue"=>"required|max:255",
            "description"=>"required|max:255",
            "event_from_time"=>"required|date_format:Y-m-d|after:yesterday",
            "event_to_time"=>"required|date_format:Y-m-d|after:event_from_time",
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $objEventMaster = EventMaster::create([
            'event_name' => $input['event_name'],
            'venue' => $input['venue'],
            'description' => $input['description'],
            'event_from_time' => $input['event_from_time'],
            'event_to_time' => $input['event_to_time'],
        ]);

        if(! empty($objEventMaster->id)) {
            return redirect()->route("event.index")->with("success","Event added successfully");
        }

        return redirect()->route("event.index")->with("message","Unable to add event, Please try agin later");
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
        $objEvent = EventMaster::find($id);
        if(empty($objEvent->id))
        {
            return redirect()->route('home');
        }

        return view('event.edit')->with('objEvent', $objEvent);
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
        $input = $request->all();

        $rules = [
            "event_name"=>"required|max:255|unique:event_masters,event_name,".$id,
            "venue"=>"required|max:255",
            "description"=>"required|max:255",
            "event_from_time"=>"required|date_format:Y-m-d|after:today",
            "event_to_time"=>"required|date_format:Y-m-d|after:event_from_time",
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $objEvent = EventMaster::find($id);
        if(empty($objEvent->id)) {
            return redirect()->route('event.index')->with("message","No event found");
        }

        $objEvent->event_name = $input['event_name'];
        $objEvent->venue = $input['venue'];
        $objEvent->description = $input['description'];
        $objEvent->event_from_time = $input['event_from_time'];
        $objEvent->event_to_time = $input['event_to_time'];

        $objEvent->save();

        return redirect()->back()->with("success", "Event updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $objEvent = EventMaster::find($id);
        if(empty($objEvent->id)) {
           return response()->json(["success"=>false, "message"=>"Unable to find event"]); 
        }

        $objEvent->delete();

        return response()->json(["success"=>true, "message"=>"Event deleted successfully"]);
    }
}
