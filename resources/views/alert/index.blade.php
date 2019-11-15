<div class="container">
    <div class="row justify-content-center" id="alert_div">
        @if(session()->has("message"))
        <div class="col-md-6 col-lg-6 col-12">
            <div class="b-s-20"></div>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get("message") }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        @if(session()->has("success"))
        <div class="col-md-6 col-lg-6 col-12">
            <div class="b-s-20"></div>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get("success") }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>