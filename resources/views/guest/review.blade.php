@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row h-100">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="login_box">
                <div class="user_deatils">
                    <ul>
                        <li><span>Ticket No:</span> {{ $objGuest->ticket_number }}</li>
                        <li><span>Name:</span> {{ $objGuest->name }}</li>
                        <li><span>Type:</span> {{ $objGuest->guest_type }}</li>
                        <li><span>Status:</span>Open</li>
                    </ul>
                </div>
                <form action="{{ route("guest.review.post", $objGuest->ticket_number) }}" method="POST" >
                    @csrf
                    <div class="rating_block">
                        <ul>
                            <li class="position-relative"><span>Company Rating:</span> 
                                <fieldset class="rating">
                                    <input type="radio" id="cstar5" name="company_rating" value="5" {{ old("company_rating") == "5" ? "checked" : "" }} /><label class = "full" for="cstar5" title="Awesome - 5 stars"></label>
                                    <input type="radio" id="cstar4" name="company_rating" value="4" {{ old("company_rating") == "4" ? "checked" : "" }}/><label class = "full" for="cstar4" title="Pretty good - 4 stars"></label>
                                    <input type="radio" id="cstar3" name="company_rating" value="3" {{ old("company_rating") == "3" ? "checked" : "" }}/><label class = "full" for="cstar3" title="Meh - 3 stars"></label>
                                    <input type="radio" id="cstar2" name="company_rating" value="2" {{ old("company_rating") == "2" ? "checked" : "" }}/><label class = "full" for="cstar2" title="Kinda bad - 2 stars"></label>
                                    <input type="radio" id="cstar1" name="company_rating" value="1" {{ old("company_rating") == "1" ? "checked" : "" }}/><label class = "full" for="cstar1" title="Sucks big time - 1 star"></label>
                                </fieldset>
                                @error('company_rating')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </li>
                            <li class="position-relative"><span>Product Rating:</span> 
                                <fieldset class="rating">
                                    <input type="radio" id="pstar5" name="product_rating" value="5" {{ old("product_rating") == "5" ? "checked" : "" }}/><label class = "full" for="pstar5" title="Awesome - 5 stars"></label>
                                    <input type="radio" id="pstar4" name="product_rating" value="4" {{ old("product_rating") == "4" ? "checked" : "" }}/><label class = "full" for="pstar4" title="Pretty good - 4 stars"></label>
                                    <input type="radio" id="pstar3" name="product_rating" value="3" {{ old("product_rating") == "3" ? "checked" : "" }}/><label class = "full" for="pstar3" title="Meh - 3 stars"></label>
                                    <input type="radio" id="pstar2" name="product_rating" value="2" {{ old("product_rating") == "2" ? "checked" : "" }}/><label class = "full" for="pstar2" title="Kinda bad - 2 stars"></label>
                                    <input type="radio" id="pstar1" name="product_rating" value="1" {{ old("product_rating") == "1" ? "checked" : "" }}/><label class = "full" for="pstar1" title="Sucks big time - 1 star"></label>
                                </fieldset>
                                @error('product_rating')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </li>
                            <li class="position-relative"><span>Crew Member Rating:</span>


                                <fieldset class="rating">
                                    <input type="radio" id="astar5" name="agent_rating" value="5" {{ old("agent_rating") == "5" ? "checked" : "" }}/><label class = "full" for="astar5" title="Awesome - 5 stars"></label>
                                    <input type="radio" id="astar4" name="agent_rating" value="4" {{ old("agent_rating") == "4" ? "checked" : "" }}/><label class = "full" for="astar4" title="Pretty good - 4 stars"></label>
                                    <input type="radio" id="astar3" name="agent_rating" value="3" {{ old("agent_rating") == "3" ? "checked" : "" }}/><label class = "full" for="astar3" title="Meh - 3 stars"></label>
                                    <input type="radio" id="astar2" name="agent_rating" value="2" {{ old("agent_rating") == "2" ? "checked" : "" }}/><label class = "full" for="astar2" title="Kinda bad - 2 stars"></label>
                                    <input type="radio" id="astar1" name="agent_rating" value="1" {{ old("agent_rating") == "1" ? "checked" : "" }}/><label class = "full" for="astar1" title="Sucks big time - 1 star"></label>
                                </fieldset>
                                @error('agent_rating')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </li>
                        </ul>
                    </div>

                    <div class="social_block">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-7">
                                <h3 class="sub_titile pl-0">LinkedIn QR Code</h3>
                                <img src="{{ url("images/emxcel-linkedin.png") }}">
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-7">
                                <h3 class="sub_titile pl-0">Social Likes</h3>
                                <div class="checkbox_block">
                                    <input id="fb" name="fb" class="checkbox" type="checkbox" {{ !empty(old("fb")) ? "checked" : "" }}>
                                    <label for="fb" class="checker_fb"></label>
                                </div>
                                <div class="checkbox_block">
                                    <input id="linkedin" name="linkedin" class="checkbox" type="checkbox" {{ !empty(old("linkedin")) ? "checked" : "" }}>
                                    <label for="linkedin" class="checker_linkedin"></label>
                                </div>
                                <div class="checkbox_block">
                                    <input id="twitt" name="twitt" class="checkbox" type="checkbox" {{ !empty(old("twitt")) ? "checked" : "" }}>
                                    <label for="twitt" class="checker_twitt"></label>
                                </div>
                                <div class="checkbox_block">
                                    <input id="insta" name="insta" class="checkbox" type="checkbox" {{ !empty(old("insta")) ? "checked" : "" }}>
                                    <label for="insta" class="checker_insta"></label>
                                </div>
                            </div> --}}
                            <div class="col-12 col-sm-12 col-md-5 col-lg-6 col-xl-5">
                                <h3 class="sub_titile pl-0">Subscribe</h3>
                                <div class="checkbox_block">
                                    <input id="mobile" name="mobile" class="checkbox" type="checkbox" {{ !empty(old("mobile")) ? "checked" : "" }}>
                                    <label for="mobile" class="checker_mobile"></label>
                                </div>
                                <div class="checkbox_block">
                                    <input id="mailid" name="mailid" class="checkbox" type="checkbox" {{ !empty(old("mailid")) ? "checked" : "" }}>
                                    <label for="mailid" class="checker_mailid"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="b-s-20"></div>
                                <h3 class="sub_titile pl-0">Recommendation</h3>
                                <div class="input-group">
                                    <textarea id="recommendation" type="text" class="form-control @error('recommendation') is-invalid @enderror" name="recommendation" placeholder="Enter your recommendation here">{{ old('recommendation') }}</textarea>

                                    @error('recommendation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn_submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("css")
<style type="text/css">
    fieldset, label { margin: 0; padding: 0; }
    body{ margin: 20px; }
    h1 { font-size: 1.5em; margin: 10px; }


    @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

    fieldset, label { margin: 0; padding: 0; }

    /****** Style Star Rating Widget *****/

    .rating { 
        border: none;
        float: left;
    }

    .rating > input { display: none; } 
    .rating > label:before { 
        margin: 5px;
        font-size: 1.25em;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005";
    }

    .rating > .half:before { 
        content: "\f089";
        position: absolute;
    }

    .rating > label { font-size:28px;
        color: #ddd; 
        float: right; 
    }

    /***** CSS Magic to Highlight Stars on Hover *****/

    .rating > input:checked ~ label, /* show gold star when clicked */
    .rating:not(:checked) > label:hover, /* hover current star */
    .rating:not(:checked) > label:hover ~ label { color: #01599A;  } /* hover previous stars in list */

    .rating > input:checked + label:hover, /* hover current star when changing rating */
    .rating > input:checked ~ label:hover,
    .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
    .rating > input:checked ~ label:hover ~ label { color: #01599A;  } 


    .invalid-feedback {
        display: block;
        color: #e3342f !important; position:absolute; top:auto; bottom:0;

    }
</style>
@endsection

@section("js")
<script type="text/javascript">
    $(document).ready(function(){

        $(document).ready(function() {
          $("a").on("click touchend", function(e) {
            var el = $(this);
            var link = el.attr("href");
            window.location = link;
        });
      });

    });
</script>
@endsection