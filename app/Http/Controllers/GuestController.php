<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuestRemark;
use App\GuestMaster;
use App\EventMaster;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Mail;
use Log;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("guest-list");
        $guestMasters = GuestMaster::where("assigned_user_id", Auth::user()->id)->where(function($q){
            $q->where("rating",'');
            $q->orWhereNull("rating");
        })->get();
        return view("guest.index")->with("guestMasters", $guestMasters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("guest-create");
        $agents = User::where('permissions','like',"%L2%")->get();
        $guestTypeArray = ["Industry Representative","Government Dignitary","Investor","Others"];
        return view(
            'guest.add',
            [
                "agents" => $agents,
                "guestTypeArray" => $guestTypeArray
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("guest-create");
        $input = $request->all();

        $rules = [
            "name"=>"required|max:255",
            "email"=>"required|email|max:255|unique:guest_masters",
            "mobile_number"=>"required|unique:guest_masters",
            "country_code"=>"required",
            "agent_id" =>"required|numeric",
            "guest_type" => "required",
            "note"=>"max:1000"
        ];

        $message = [
            "mobile_number.digits_between"=>"Please enter valid mobile number",
        ];

        $validator = Validator::make($input, $rules, $message);
        $validator->setAttributeNames([
            "name"=>"visitor name",
            "email"=>"visitor email",
            "mobile_number"=> "visitor mobile",
            "country_code" => "country code",
            "agent_id" => "crew member",
            "note" => "notes"
        ]);

        if($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $objGuest = GuestMaster::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'mobile_number' => $input['mobile_number'],
            "country_code" => $input['country_code'],
            "create_user_id" => Auth::user()->id,
            "event_id" => 1,
            "assigned_user_id" => $input["agent_id"],
            "guest_type" => $input["guest_type"],
            "note" => isset($input["note"]) ? $input["note"] : "",
        ]);

        $objGuest->ticket_number = "TICKET".$objGuest->id;
        $objGuest->save();

        if(! empty($objGuest->id)) {

            Mail::send("email.subscribe",["objGuest"=>$objGuest],function($mail) use ($objGuest) {
                $mail->to($objGuest->email, $objGuest->name);
                $mail->from(env("MAIL_FROM_ADDRESS"),env("MAIL_FROM_NAME"));
                $mail->subject(env("SUBSCRIBE_EMAIL_SUBJECT"));
            });

            if($objGuest->country_code == "+91") {
                $messageStatus = sendMessage($objGuest, "register");
                if($messageStatus == false) {
                    Log::info("Unable to send message to guest : ".$objGuest->name. "-". $objGuest->mobile_number);
                }
            }

            return redirect()->route("guest.thankyou",[$objGuest->ticket_number])->with("success","Welcome to our booth at Bengaluru Tech Summit 2019");
        }

        return redirect()->route("guest.index")->with("message","Unable to add visitor, Please try agin later");
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
        // $objAgent = GuestMaster::find($id);
        // if(empty($objAgent->id)) {
        //     return redirect()->route('home');
        // }

        // return view('guest.edit')->with('objAgent', $objAgent);
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
        $this->authorize("guest-assign");
        $input = $request->all();


        $rules = [
            "agent_id" =>"required|numeric",
            "guest_type" => "required",
        ];

        $validator = Validator::make($input, $rules);
        $validator->setAttributeNames([
            "agent_id"=>"crew member",
        ]);

        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $objGuest = GuestMaster::find($id);
        if(empty($objGuest->id)) {
            return redirect()->route('guest.index')->with("message","No visitor found");
        }

        $objGuest->assigned_user_id = $input['agent_id'];
        $objGuest->guest_type = $input['guest_type'];
        
        $objGuest->save();

        return redirect()->route("guest.create")->with("success", "Visitor assigned successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize("onlyAdmin");
        //
        $objAgent = GuestMaster::find($id);
        if(empty($objAgent->id)) {
           return response()->json(["success"=>false, "message"=>"Unable to find guest"]); 
        }

        $objAgent->delete();

        return response()->json(["success"=>true, "message"=>"Guest deleted successfully"]);
    }

    public function thankYou($ticketId)
    {
        $this->authorize("guest-thank-you");
        return view("guest.thankyou")->with("ticketId",$ticketId);
    }

    public function assign($ticketId)
    {
        $this->authorize("guest-assign");
        $objGuest = GuestMaster::where('ticket_number', $ticketId)->first();
        if(empty($objGuest->id))
        {
            return redirect()->route('home');
        }

        if(!empty($objGuest->guest_type)) {
            return redirect()->route("guest.create")->with("message","Visitor already assigned");
        }

        $agents = User::where('permissions','like',"%L2%")->get();
        $guestTypeArray = ["Industry Representative","Government Dignitary","Investor","Others"];
        return view("guest.assign")->with("objGuest",$objGuest)->with("agents", $agents)->with('guestTypeArray', $guestTypeArray);
    }

    public function guestReview($ticketId)
    {
        $objGuest = GuestMaster::where('ticket_number', $ticketId)->first();
        if(empty($objGuest->id))
        {
            return redirect()->route('home');
        }

        if(!empty($objGuest->rating)) {
            return redirect()->route("guest.index")->with("message","Visitor already given review");
        }
        return view("guest.review")->with("objGuest", $objGuest);
    }

    public function postGuestReview(Request $request, $ticketId)
    {
        $objGuest = GuestMaster::where('ticket_number', $ticketId)->first();
        if(empty($objGuest->id))
        {
            return redirect()->route('home');
        }

        if(!empty($objGuest->rating)) {
            return redirect()->route("guest.index")->with("message","Visitor already given review");
        }

        $input = $request->all();

        $rules = [
            "company_rating" => "required|numeric",
            "product_rating" => "required|numeric",
            "agent_rating" => "required|numeric",
            "recommendation" => "max:500",
        ];

        $validator = Validator::make($input, $rules);
        $validator->setAttributeNames([
            "agent_rating" => "crew member"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $objGuest->rating = $input['company_rating'];
        $objGuest->product_rating = $input['product_rating'];
        $objGuest->agent_rating = $input['agent_rating'];

        // $objGuest->fb_like = !empty($input['fb']) ? 1 : 0;
        // $objGuest->linkedin_like = !empty($input['linkedin']) ? 1 : 0;
        // $objGuest->twitter_like = !empty($input['twitt']) ? 1 : 0;
        // $objGuest->insta_like = !empty($input['insta']) ? 1 : 0;
        $objGuest->mobile_subscribe = !empty($input['mobile']) ? 1 : 0;
        $objGuest->email_subscribe = !empty($input['mailid']) ? 1 : 0;
        $objGuest->recommendation = !empty($input["recommendation"]) ? $input["recommendation"] : null;

        $objGuest->save();

        // if($objGuest->email_subscribe == 1) {
            Mail::send("email.after_feedback",["objGuest"=>$objGuest],function($mail) use ($objGuest) {
                $mail->to($objGuest->email, $objGuest->name);
                $mail->from(env("MAIL_FROM_ADDRESS"),env("MAIL_FROM_NAME"));
                $mail->subject(env("FEEDBACK_EMAIL_SUBJECT"));
            });
        // }

        if($objGuest->country_code == "+91" ) {
            // && $objGuest->mobile_subscribe == 1
            $messageStatus = sendMessage($objGuest, "feedback");
            if($messageStatus == false) {
                Log::info("Unable to send message to guest in feedback: ".$objGuest->name. "-". $objGuest->mobile_number);
            }
        }

        return redirect()->route("guest.index")->with("success", "Visitor ratings submitted successfully");
    }

    public function adminIndex(Request $request)
    {
        $input = $request->all();

        $guestMasters = GuestMaster::with(['event',"createUser","assignUser"]);

        if (!empty($input["event_id"])) {
            $guestMasters->where('event_id', $input['event_id']);
        }

        $guestMasters = $guestMasters->orderBy('id','desc')->get();

        if (isset($input['export'])) {
            return GuestMaster::exportGuestMaster($guestMasters);
        }

        $events = EventMaster::get();
        return view("guest.admin.index")->with("guestMasters", $guestMasters)->with("events", $events)->with("input", $input);
    }

    public function adminView($id)
    {
        $objGuest = GuestMaster::with(['event'])->find($id);

        if(empty($objGuest)) {
            return redirect()->route('home');
        }

        $remarks = GuestRemark::where('guest_master_id', $objGuest->id)->get();

        return view("guest.admin.view")->with('objGuest', $objGuest)->with("remarks",$remarks);
    }

    public function guestRevisitListing()
    {
        $guestMasters = GuestMaster::with(['event',"createUser","assignUser"]);
        $guestMasters = $guestMasters->orderBy('id','desc')->get();

        return view("guest.revisit.index")->with("guestMasters", $guestMasters);
    }

    public function guestRevisitFeedback(Request $request, $ticketId)
    {
        $objGuest = GuestMaster::where('ticket_number',$ticketId)->first();
        if(empty($objGuest->ticket_number)) {
            return redirect()->route("guest.revisit.index");
        }

        $remarks = GuestRemark::with(["createUser"])->where("guest_master_id", $objGuest->id)->orderBy('id','asc')->get();

        return view("guest.revisit.feedback")->with("objGuest", $objGuest)->with("remarks", $remarks);
    }

    public function postGuestRevisitFeedback(Request $request)
    {
        $input = $request->all();

        $rules = [
            "remarks"=>"required|max:1000",
            "guest_master_id" => "required|numeric",
        ];

        $v = Validator::make($input, $rules);

        if($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v);
        }

        $objRemark = new GuestRemark;

        $objRemark->created_by = Auth::user()->id;
        $objRemark->guest_master_id = $input["guest_master_id"];
        $objRemark->remarks = $input['remarks'];

        $objRemark->save();

        return redirect()->back()->with("success","Remark/Comments added successfully");
    }
}
