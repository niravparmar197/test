<?php

function formattedDate($date)
{
	return date("d M Y", strtotime($date));
}

function formattedDateTime($date)
{
	return date("d M Y h:i:s A", strtotime($date));
}

function onlyDate($date)
{
	return date("Y-m-d", strtotime($date));
}

function getDuration($fromDate, $toDate)
{
	$fromTimestamp = strtotime($fromDate);
	$toTimestamp = strtotime($toDate);

	$difference = $toTimestamp - $fromTimestamp;

	$hours = floor($difference / 3600);
	$minutes = floor(($difference / 60) % 60);
	$minutes = ($minutes < 9) ? '0'.$minutes : $minutes;
	$hours = ($hours < 9) ? '0'.$hours : $hours;

	// $seconds = $difference % 60;

	return $hours.":".$minutes;
}

function sendMessage($objGuest, $message_type)
{

	$workingkey = env("SMS_KEY","A23cf3edc7679fcdb0d8e74eeacc320fa");
	$senderID = env("SMS_SENDER_ID","BEEPIT");
	$message = "welcome to EMXCEL";
	if($message_type == "register") {
		$message = trans(
			"messages.register_message",
			[
				"name"=>ucwords($objGuest->name),
				"website_url_in_sms"=>env("WEBSITE_URL_IN_SMS","bit.ly/2NtU02A")
			]
		);
	} elseif($message_type == "feedback") {
		$message = trans(
			"messages.feedback_message",
			[
				"name"=>ucwords($objGuest->name),
				"linkedin_link"=>env("LINKEDIN_LINK","bit.ly/33xMQQe"),
				"twitter_link"=>env("TWITTER_LINK","bit.ly/33GuRaJ")
			]
		);
	}


	$mobile_number = str_replace(" ","", $objGuest->mobile_number);
	if(!is_numeric($mobile_number)) {
		return false;
	}

	$curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => env("SMS_URL","http://sms.alphacomputers.biz/api/web2sms.php"),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => [
        	"workingkey" => $workingkey,
        	"to" => $objGuest->country_code.$mobile_number,
        	"sender" => $senderID,
        	"message" => $message
        ]
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    \Log::debug($err);
    \Log::debug($response);

    if ($err) {
    	return false;
    } else {
    	return true;
    }
}