<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = User::where("role_id",'!=',1)->get();
        return view("agent.index")->with("agents", $agents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agent.add');
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
            "name"=>"required|max:255",
            "email"=>"required|email|max:255|unique:users",
            "mobile_number"=>"required|digits:10",
            "password"=>"required|min:8|max:255|confirmed",
            "agent_permission"=>"required|array",
        ];

        $validator = Validator::make($input, $rules);
        $validator->setAttributeNames([
            "name"=>"crew member name",
            "email"=>"crew member email",
            "mobile_number"=> "crew member mobile",
            "agent_permission"=> "crew member type"
        ]);

        if($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $objUser = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'mobile_number' => $input['mobile_number'],
            'password' => Hash::make($input['password']),
            "role_id" => 2,
            "permissions" => json_encode($input['agent_permission']),
        ]);

        if(! empty($objUser->id)) {
            return redirect()->route("agent.index")->with("success","Crew member added successfully");
        }

        return redirect()->route("agent.index")->with("message","Unable to add crew member, Please try agin later");
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
        $objAgent = User::find($id);
        if(empty($objAgent->id))
        {
            return redirect()->route('home');
        }

        return view('agent.edit')->with('objAgent', $objAgent);
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
            "name"=>"required|max:255",
            "email"=>"required|email|max:255|unique:users,email,".$id,
            "mobile_number"=>"required|digits:10",
            "agent_permission"=>"required|array",
        ];

        if(!empty($input['password'])) {
            $rules['password'] = "min:8|max:255|confirmed";
        }

        $validator = Validator::make($input, $rules);
        $validator->setAttributeNames([
            "name"=>"crew member name",
            "email"=>"crew member email",
            "mobile_number"=> "crew member mobile",
            "agent_permission"=> "crew member type"
        ]);

        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $objAgent = User::find($id);
        if(empty($objAgent->id)) {
            return redirect()->route('agent.index')->with("message","No crew member found");
        }

        $objAgent->name = $input['name'];
        $objAgent->mobile_number = $input['mobile_number'];
        $objAgent->email = $input['email'];
        $objAgent->permissions = json_encode($input['agent_permission']);
        if(!empty($input['password'])) {
            $objAgent->password = Hash::make($input['password']);
        }
        $objAgent->save();

        return redirect()->back()->with("success", "Crew member updated successfully");
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
        $objAgent = User::find($id);
        if(empty($objAgent->id)) {
           return response()->json(["success"=>false, "message"=>"Unable to find crew member"]); 
        }

        $objAgent->delete();

        return response()->json(["success"=>true, "message"=>"Crew member deleted successfully"]);
    }
}
