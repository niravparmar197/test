<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestMaster extends Model
{
    //
    protected $fillable = ["name","mobile_number","email","create_user_id","event_id","country_code","assigned_user_id","guest_type","note"];

    public function event()
    {
    	return $this->belongsTo(EventMaster::class, "event_id");
    }

    public function createUser()
    {
    	return $this->belongsTo(User::class, "create_user_id");
    }

    public function assignUser()
    {
    	return $this->belongsTo(User::class, "assigned_user_id");
    }

    public static function exportGuestMaster($guestMasters)
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=guest_list.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array("#","Ticket No","Guest Name","Email","Mobile","Guest Type","Event","Created By","Assigned To","Company Rating","Product Rating","Crew Member Rating","Mobile Subscription","Email Subscription","Notes","Recommendation","In Time","Out Time","Duration (HH:MM)");


        $callback = function() use ($guestMasters, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);


            foreach($guestMasters as $key => $guest) {
                $guestRemarks = GuestRemark::with(["createUser"])->where("guest_master_id", $guest->id)->get();
                $finalArray = [
                    ($key+1),
                    $guest->ticket_number,
                    $guest->name,
                    $guest->email,
                    $guest->country_code." ".$guest->mobile_number,
                    $guest->guest_type,
                    isset($guest->event->event_name) ? $guest->event->event_name : "",
                    isset($guest->createUser->name) ? $guest->createUser->name : "",
                    isset($guest->assignUser->name) ? $guest->assignUser->name : "",
                    $guest->rating,
                    $guest->product_rating,
                    $guest->agent_rating,
                    !empty($guest->mobile_subscribe) ? "Yes" : "No",
                    !empty($guest->email_subscribe) ? "Yes" : "No",
                    $guest->note,
                    $guest->recommendation,
                    formattedDateTime($guest->created_at),
                    formattedDateTime($guest->updated_at),
                    getDuration($guest->created_at,$guest->updated_at)
                ];
                foreach($guestRemarks as $remark) {
                    $nameDate = isset($remark->createUser->name) ? $remark->createUser->name : "User";
                    $nameDate.= " | ".formattedDateTime($remark->created_at);

                    array_push($finalArray, $nameDate."\r\n".$remark->remarks);
                    // array_push($finalArray, $remark->remarks);
                }
                fputcsv($file, $finalArray);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
