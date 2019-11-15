@extends('layouts.app')

@section('content')
@include("alert.index")
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="login_logo">
                <div class="row ">
                    <div class="col-12 co-md-12 col-lg-12">
                        <div class="b-s-20"></div>
                        <div class="card">
                            <div class="card-header">
                                <div class="col-xs-12 d-flex justify-content-between align-items-center">
                                    <span class="card-header-text ">Guest Filter</span>
                                </div>
                            </div>

                            <div class="card-body">
                                <form action="{{ route("guest.admin.index") }}">
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6 text-left">
                                            <div class="form-group">
                                                <label class="label" for="event_id">Event</label>
                                                <select name="event_id" id="event_id" class="form-control">
                                                    <option value="">All</option>
                                                    @foreach($events as $event)
                                                    <option value="{{ $event->id }}" {{ !empty($input['event_id']) && $input['event_id'] == $event->id ? "selected" : ""  }}>{{ $event->event_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label class="label" for="event_id" style="opacity:0">Event</label>
                                            <div class="form-group text-left">

                                                <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <button type="submit" name="export" class="btn btn-primary" value="export"><i class="fa fa-download"></i> Export as CSV</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="b-s-20"></div>
                        <div class="card">
                            <div class="card-header">
                                <div class="col-xs-12">
                                    <span class="card-header-text d-flex justify-content-between align-items-center">Guest Listing</span>
                                </div>
                            </div>

                            <div class="card-body">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <div class="table-responsive">
                                    <table class="table table-striped text-left" id="agent_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Guest Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                {{-- <th>Guest Type</th> --}}
                                                <th>Event</th>
                                                <th>In Time</th>
                                                <th>Out Time</th>
                                                <th>Duration (HH:MM)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($guestMasters as $key => $guest)
                                            <tr>
                                                <td>{{ ($key+1) }}</td>
                                                <td>{{ $guest->name }}</td>
                                                <td>{{ $guest->email }}</td>
                                                <td>{{ $guest->country_code." ".$guest->mobile_number }}</td>
                                                {{-- <td>{{ $guest->guest_type }}</td> --}}
                                                <td>{{ isset($guest->event->event_name) ? $guest->event->event_name : "" }}</td>
                                                <td>{{ formattedDateTime($guest->created_at) }}</td>
                                                <td>{{ formattedDateTime($guest->updated_at) }}</td>
                                                <td>{{ getDuration($guest->created_at,$guest->updated_at) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route("guest.admin.view",[$guest->id]) }}" title="View Guest" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a><span style="width:5px"></span><a href="#" data-url="{{ route("guest.destroy",[$guest->id]) }}" class="btn btn-sm btn-danger btn-delete" title="Delete Guest"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="{{ url("js/select2/css/select2.min.css") }}">
<style type="text/css">
    #agent_table{
        margin:0 -6px;
    }
    .select2-container .select2-selection--single{height:auto;}
    .select2-container--default .select2-selection--single .select2-selection__rendered{padding-top:4px; padding-bottom:4px; padding-left:14px}
    .select2-container--default .select2-selection--single .select2-selection__arrow{height:34px}
</style>
@endsection

@section("js")
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ url("js/select2/js/select2.min.js") }}"></script>
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $("#agent_table").DataTable({responsive:true});
        $("#event_id").select2();

        $("#agent_table").on("click",".btn-delete",function(e){
            var ans =  confirm("Are you sure to delete this guest?");
            var url = $(this).data("url");
            var _token = $("#_token").val();
            var tr = $(this).parents("tr");
            if(ans) {
                $.ajax({
                    "url":url,
                    "method":"delete",
                    "data":{"_token":_token},
                    "headers":{
                        "accept":"application/json",
                    },
                    success:function(data, status, xhr){
                        if(data.success)
                        {
                            table.row(tr).remove().draw(false);
                            var message = '<div class="col-md-6 col-lg-6 col-12">'+
                            '<div class="b-s-20"></div>'+
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                            data.message+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                            '</div>'+
                            '</div>';
                        }
                        else {
                            var message = '<div class="col-md-6 col-lg-6 col-12">'+
                            '<div class="b-s-20"></div>'+
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                            data.message+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                            '</div>'+
                            '</div>'; 
                        }
                        $("#alert_div").html("");
                        $("#alert_div").append(message);
                    }
                });
            }
        });
    });
</script>
@endsection