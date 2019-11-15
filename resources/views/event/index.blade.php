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
                                    <span class="card-header-text">Event Listing</span>
                                    <a class="btn btn-primary float-right" href="{{ route("event.create") }}">Add Event</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <div class="table-responsive">
                                    <table class="table table-striped text-left" id="event_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Event Name</th>
                                                <th>Event Venue</th>
                                                <th>From Time</th>
                                                <th>To Time</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($events as $key => $event)
                                            <tr>
                                                <td>{{ ($key+1) }}</td>
                                                <td>{{ $event->event_name }}</td>
                                                <td>{{ $event->venue }}</td>
                                                <td>{{ formattedDate($event->event_from_time) }}</td>
                                                <td>{{ formattedDate($event->event_to_time) }}</td>
                                                <td>{{ formattedDateTime($event->created_at) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route("event.edit",[$event->id]) }}" title="Edit Event" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a><span style="width: 5px"></span><a href="#" data-url="{{ route("event.destroy",[$event->id]) }}" class="btn btn-sm btn-danger btn-delete" title="Delete Event"><i class="fa fa-trash"></i></a>
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
<style type="text/css">
    #event_table{
        margin:0 -4px;
    }
</style>
@endsection

@section("js")
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $("#event_table").DataTable();

        $("#event_table").on("click",".btn-delete",function(e){
            var ans =  confirm("Are you sure to delete this event?");
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