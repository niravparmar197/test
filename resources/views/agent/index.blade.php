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
                                    <span class="card-header-text">Crew Listing</span>
                                    <a class="btn btn-primary float-right" href="{{ route("agent.create") }}">Add Crew Member</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <div class="table-responsive">
                                    <table class="table table-striped text-left" id="agent_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Type</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($agents as $key => $agent)
                                            <tr>
                                                <td>{{ ($key+1) }}</td>
                                                <td>{{ $agent->name }}</td>
                                                <td>{{ $agent->email }}</td>
                                                <td>{{ $agent->mobile_number }}</td>
                                                @php($permissions = json_decode($agent->permissions))
                                                <td>
                                                    <ul>
                                                        @foreach($permissions as $value)
                                                        <li>{{ $value == "L1" ? "Level 1" : "Level 2" }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ formattedDateTime($agent->created_at) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route("agent.edit",[$agent->id]) }}" title="Edit Crew Member" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a><span style="width: 5px"></span><a href="#" data-url="{{ route("agent.destroy",[$agent->id]) }}" class="btn btn-sm btn-danger btn-delete" title="Delete Crew Member"><i class="fa fa-trash"></i></a>
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
        margin:0 -4px;
    }
</style>
@endsection

@section("js")
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $("#agent_table").DataTable({responsive:true});

        $("#agent_table").on("click",".btn-delete",function(e){
            var ans =  confirm("Are you sure to delete this crew member?");
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