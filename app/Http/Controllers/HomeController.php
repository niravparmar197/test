<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EventMaster;
use App\GuestMaster;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role_id == 1) {
            $agentsCount = User::where("role_id",'!=',1)->count();
            $eventsCount = EventMaster::count();
            $guestsCount = GuestMaster::count();
            return view('home')->with("agentsCount",$agentsCount)->with("eventsCount", $eventsCount)->with('guestsCount', $guestsCount);
        } else {
            $permissions = json_decode(Auth::user()->permissions);
            if(in_array("L1", $permissions) && in_array("L2", $permissions)) {
                return view('home');
            } elseif(in_array("L1", $permissions)) {
                return $this->setDashboard(1);
            } else {
                return $this->setDashboard(2);
            }
        }
    }

    public function setDashboard($id)
    {
        session()->put("active_dashboard",$id);
        if($id == 1) {
            return redirect()->route("guest.create");
        } else {
            return redirect()->route("guest.index");
        }
    }

    public function levelTwoDashboard()
    {
        return view("guest.index");
    }

    public function levelOneDashboard()
    {
        return view("guest.add");
    }
}
