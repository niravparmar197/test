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
                                                {{-- <th>#</th> --}}
                                                <th>Ticket</th>                                  
                                                <th>Guest Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                {{-- <th>Guest Type</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($guestMasters as $key => $guest)
                                            <tr>
                                                {{-- <td>{{ ($key+1) }}</td> --}}
                                                <td data-sort="{{ ($key+1) }}">{{ $guest->ticket_number }}</td>
                                                <td>{{ $guest->name }}</td>
                                                <td>{{ $guest->email }}</td>
                                                <td>{{ $guest->country_code." ".$guest->mobile_number }}</td>
                                                {{-- <td>{{ $guest->guest_type }}</td> --}}
                                                {{-- <td>{{ isset($guest->event->event_name) ? $guest->event->event_name : "" }}</td> --}}
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route("guest.revisit.feedback",[$guest->ticket_number]) }}" title="View/Add Feedback" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
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
    #agent_table{
        margin:0 -6px;
    }
</style>
@endsection

@section("js")
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var table;
    $(document).ready(function(){

        var columns = [{
            "targets": [ 2,3 ],
            "visible": false,
            "searchable": true
        }];
        if($(window).width() >= 768 ){
            columns = [{
                "targets": [ 2 ],
                "visible": false,
                "searchable": true
            }]; 
        }
        if($(window).width() >= 991 ){
            columns = []; 
        }
        table = $("#agent_table").DataTable({
            responsive:true,
            columnDefs: columns
        });
    });
    // $( window ).resize(function() {
    //     if($(window).width() > 768) {
    //         table.column( 3 ).visible( true );
    //     } else {
    //         table.column( 2 ).visible( false );
    //         table.column( 3 ).visible( false );
    //     }
    //     // console.log()
    // });
</script>
@endsection