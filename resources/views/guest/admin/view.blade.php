@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 align-self-center">
        <div class="login_box">
            <div class="row h-100">
                <div class="user_deatils">
                    <ul>
                        <li><span>Ticket No:</span> {{ $objGuest->ticket_number }}</li>
                        <li><span>Guest Name:</span> {{ $objGuest->name }}</li>
                        <li><span>Email:</span> {{ $objGuest->email }}</li>
                        <li><span>Mobile:</span> {{ $objGuest->country_code." ".$objGuest->mobile_number }}</li>
                        <li><span>Type:</span> {{ $objGuest->guest_type }}</li>
                        <li><span>Event:</span> {{ isset($objGuest->event->event_name) ? $objGuest->event->event_name : "" }}</li>
                        <li><span>Event Dates:</span>
                            @if(!empty($objGuest->event))
                                {{ formattedDate($objGuest->event->event_from_time) }} To {{ formattedDate($objGuest->event->event_to_time) }}
                            @endif
                        </li>
                        <li><span>Created By:</span> {{ isset($objGuest->createUser->name) ? $objGuest->createUser->name : "" }}</li>
                        <li><span>Assigned To:</span> {{ isset($objGuest->assignUser->name) ? $objGuest->assignUser->name : "" }}</li>
                        <li><span>Company Rating:</span>
                            @if(!empty($objGuest->rating))
                                @for($i=0;$i<$objGuest->rating;$i++) 
                                    <i class="fa fa-star text-blue"></i>
                                @endfor
                            @endif
                        </li>
                        <li><span>Product Rating:</span>
                            @if(!empty($objGuest->product_rating))
                                @for($i=0;$i<$objGuest->product_rating;$i++) 
                                    <i class="fa fa-star text-blue"></i>
                                @endfor
                            @endif
                        </li>
                        <li><span>Crew Member Rating:</span>
                            @if(!empty($objGuest->agent_rating))
                                @for($i=0;$i<$objGuest->agent_rating;$i++) 
                                    <i class="fa fa-star text-blue"></i>
                                @endfor
                            @endif
                        </li>
                        {{-- <li><span>Facbook Like:</span><i class="fa{{ !empty($objGuest->fb_like) ? " fa-check text-success" : " fa-times text-danger" }}"></i></li>
                        <li><span>LinkedIn Like:</span><i class="fa{{ !empty($objGuest->linkedin_like) ? " fa-check text-success" : " fa-times text-danger" }}"></i></li>
                        <li><span>Twiiter Like:</span><i class="fa{{ !empty($objGuest->twitter_like) ? " fa-check text-success" : " fa-times text-danger" }}"></i></li>
                        <li><span>Instagram Like:</span><i class="fa{{ !empty($objGuest->insta_like) ? " fa-check text-success" : " fa-times text-danger" }}"></i></li> --}}
                        <li><span>Mobile Subscription:</span><i class="fa{{ !empty($objGuest->mobile_subscribe) ? " fa-check text-success" : " fa-times text-danger" }}"></i></li>
                        <li><span>Email Subscription:</span><i class="fa{{ !empty($objGuest->mobile_subscribe) ? " fa-check text-success" : " fa-times text-danger" }}"></i></li>
                        <li><span>Note:</span>{{ $objGuest->note }}</li>
                        <li><span>Recommendation:</span>{{ $objGuest->recommendation }}</li>
                        <li><span>In Time:</span>{{ formattedDateTime($objGuest->created_at) }}</li>
                        <li><span>Out Time:</span>{{ formattedDateTime($objGuest->updated_at) }}</li>
                        <li><span>Duration:</span>{{ getDuration($objGuest->created_at,$objGuest->updated_at) }} ( HH:MM )</li>
                        {{-- <li><span>Status:</span> Open</li> --}}
                    </ul>
                </div>
                <div class="b-s-30"></div>
                <h3 class="sub_titile pl-0">Remarks/Comments History</h3>
                <div class="user_deatils es">
                    <ul>
                        @foreach($remarks as $remark)
                        <li>
                            <div class="font-weight-bold">{{ isset($remark->createUser->name) ? $remark->createUser->name : "User" }}:</div>
                            <p class="remark-time-date">{{ formattedDateTime($remark->created_at) }}</p>
                            {{ $remark->remarks }}                             
                        </li>
                        @endforeach
                    </ul>
                </div>
                    <div class="b-s-50"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("css")
<style type="text/css">
    .text-yellow{
        color: #ffbf00 !important;
    }
    .text-blue{
        color: #01599A !important;
    }
</style>
@endsection

@section("js")
@endsection