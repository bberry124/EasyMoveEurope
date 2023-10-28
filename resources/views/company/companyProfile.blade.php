@extends("layouts.app")

@section("style")
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <style>
        .iti{
            width:100%;
        }
        </style>
@endsection

@section("content")                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               </header>
    <section class="container dashboard">
        <div class="dashboard-area">
            @include("partials.companySidebar")
            <section class="col-lg-8 col-md-7 col-sm-12 col-12 profile-section">

                <div class="px-5 py-5">
                    <div class="col-lg-12">
                        <div class="header-content d-flex justify-content-between">
                            <h2 class="title fredoka">{{__('Profile Details')}}</h2>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa fa-edit"></i>{{__('Edit')}}
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="alert alert-danger print-error-msg">
                                        <ul></ul>
                                    </div>
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{__('Profile Details')}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{__('Close')}}"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            @foreach($profiles as $key => $data)
                                                <div class="mb-3 d-none">
                                                    <label for="uid" class="col-form-label">{{__('ID:')}}</label>
                                                    <input type="text" class="form-control" id="uid" value="{{$data->id}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="uname" class="col-form-label">{{__('Company Name')}}:</label>
                                                    <input type="text" class="form-control" id="uname" value="{{$data->company_name}}">
                                                </div>
                                            @if($data->ship_area)
                                                <div class="mb-3">
                                                    <label for="uname" class="col-form-label">{{__('Ship Area')}}:</label>
                                                    <select class="form-control" id="ship_area">
                                                        <option value="domestic" {{$data->ship_area == 'domestic' ? 'selected' : ''}}>{{__("Domestic")}}</option>
                                                        <option value="international" {{$data->ship_area == 'international' ? 'selected' : ''}}>{{__("International")}}</option>

                                                    </select>
                                                </div>



                                                @endif

                                                <div class="mb-3">
                                                    <label for="ucountry" class="col-form-label">{{__('Company Country')}}:</label>
                                                    <select id="ucountry" name="company_country" onchange="getCountryCode($(this).find('option:selected').attr('data-country'))"
                                                            class="reg-text form-control @error('country') is-invalid @enderror" required>

                                                        @foreach(allCountries(1) as $country_key => $country)


                                                            <option data-country="{{$country_key}}" value="{{$loop->iteration > 1 ?  $country : $country_key}}" {{$country == $data->company_country ? 'selected' : ""}}>{{__($country)}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="uname" class="col-form-label">{{__('Email')}}:</label>
                                                    <input type="email" class="form-control" id="email" value="{{$data->email}}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="uname" class="col-form-label">{{__('Phone')}}:</label>
                                                    <input type="text" class="form-control" id="uphone" value="{{$data->phone}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="uname" class="col-form-label">{{__('Your Contact Name')}}:</label>
                                                    <input type="text" class="form-control" id="name" value="{{$data->name}}">
                                                </div>



                                                <div class="mb-3">
                                                    <label for="uemail" class="col-form-label">{{__('VAT-ID:')}}</label>
                                                    <input class="form-control" id="uvat" value="{{$data->vat_name}}">
                                                    <input type="hidden" class="form-control" id="vvat" value="{{$data->valid_vat}}">
                                                    <span class="pull-left" style="color:#1a1acf">{{__("VAT Validation Status")}}:</span>
                                                    <span class="pull-right" style="color:#1a1acf"><span class="valid_text">{{__("Valid VAT ID")}}</span>&nbsp;(<span class="update-valid-vat"> {{$data->valid_vat ? '0%' : '19%'}}</span>)
                                                        <br>
                                                        <br>
                                                    <button type="button" onclick="verify_vat($('#uvat').val())" class="btn btn-primary btn-md">{{__("Verify in VIES")}}</button>
                                                    </span>

                                                </div>
                                                <br>
                                                <br>
                                                <br>

                                                <div class="mb-3">
                                                    <label for="uemail" class="col-form-label">{{__('Street name, number')}}</label>
                                                    <input class="form-control" id="location" value="{{$data->location}}">
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="uemail" class="col-form-label">{{__('Zip Code')}}</label>
                                                            <input class="form-control" id="zipcode" value="{{$data->zipcode}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="uemail" class="col-form-label">{{__('City')}}</label>
                                                            <input class="form-control" id="city" value="{{$data->city}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="uemail" class="col-form-label">{{__('Invoice Type')}}</label>
                                                            <select class="form-control" id="invoice_type" name="invoice_type">
                                                                @if($data->invoice_type == "" || $data->invoice_type == "Per Order")
                                                                <option value="Per Order">{{__('Per Order')}}</option>
                                                                <option value="Per Week">{{__('Per Week')}}</option>
                                                                <option value="Per Month">{{__('Per Month')}}</option>
                                                                @endif
                                                                @if($data->invoice_type == "Per Week")
                                                                <option value="Per Week">{{__('Per Week')}}</option>
                                                                <option value="Per Order">{{__('Per Order')}}</option>
                                                                <option value="Per Month">{{__('Per Month')}}</option>
                                                                @endif
                                                                @if($data->invoice_type == "Per Month")
                                                                <option value="Per Month">{{__('Per Month')}}</option>
                                                                <option value="Per Order">{{__('Per Order')}}</option>
                                                                <option value="Per Week">{{__('Per Week')}}</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                                        <button type="button" class="btn btn-primary" id="profile_btn">{{__('Save changes')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            @foreach($profiles as $key => $data)
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Company Name')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{$data->company_name}}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Email')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{$data->email}}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Phone')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{$data->phone}}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    @if($data->ship_area)
                                        <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Ship Area')}}:</p>
                                        </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{$data->ship_area}}</p>
                                            </div>

                                        </div>
                                </div>
                                        <hr>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Company Country')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{$data->company_country}}</p>
                                        </div>
                                    </div>
                                    <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('Contact Name')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$data->name}}</p>
                                    </div>
                                </div>
                                <hr>



                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Street name, number')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{$data->location ?? "N/A"}}</p>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Zip Code')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{$data->zipcode ?? "N/A"}}</p>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('City')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{$data->city ?? "N/A"}}</p>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('VAT-ID')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{$data->vat_name}}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row" style="padding-bottom:14px;">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Invoice Type')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $data->invoice_type ? __($data->invoice_type) : __('Per Order') }}</p>
                                        </div>
                                    </div>
                                    @if($data->credit_balance != "" && $data->credit_balance != "0")
                                    <hr>
                                    <div class="row" style="padding-bottom:14px;">
                                        <div class="col-sm-3">
                                            <p class="mb-0">{{__('Credit Balance')}}</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{number_format($data->credit_balance,2,".",",")}}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                            @endforeach
                        </div>
                                        <div class="col-lg-12">
                        <div class="header-content d-flex justify-content-between">
                            <h2 class="title fredoka">{{__('Password')}}</h2>
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModalTwo">
                                <i class="fa fa-edit"></i>{{__('Edit')}}
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalTwo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="alert alert-danger print-error-msg">
                                        <ul></ul>
                                    </div>
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{__('Password')}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{__('Close')}}"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            @foreach($profiles as $key => $data)
                                                <div class="mb-3 d-none">
                                                    <label for="uid" class="col-form-label">{{__('ID:')}}</label>
                                                    <input type="text" class="form-control" id="uid" value="{{$data->id}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="old_password" class="col-form-label">{{__('Password')}}:</label>
                                                    <input type="password" class="form-control" id="old_password" value="" placeholder="{{__("old password")}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="new_password" class="col-form-label">New {{__('Password')}}:</label>
                                                    <input type="password" class="form-control" id="new_password" value="" placeholder="{{__("new password")}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="confirm_password" class="col-form-label">Confirm {{__('Password')}}:</label>
                                                    <input type="password" class="form-control" id="confirm_password" value="" placeholder="{{__("confirm password")}}">
                                                </div>
                                            @endforeach
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                                            <button type="button" class="btn btn-primary" id="password_btn">{{__('Save changes')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('Password')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">xxxxxxxxxxxxxxxx</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <script type="text/javascript">
        $(function () {
            upcomingCount = {{$upcomingCount}};
            upcomingRepair = {{$upcomingRepair}};
            if(upcomingCount == '0') {
                $('#sidebar_booking').hide();
            }
            if(upcomingRepair == '0') {
                $('#sidebar_quote').hide();
            }

        });
    </script>
    <script>
        $(document).ready(function() {
          $("#profile_btn").click(function() {
            var _token = $("input[name='_token']").val();
            var uid = $('#uid').val();
            var uname = $('#uname').val();
            var uphone = $('#uphone').val();
            var ucountry = $('#ucountry').val();
            var uvat = $('#uvat').val();
            var ship_area = $("#ship_area").val();
            var contact_name = $("#name").val();
            var email = $("#email").val();
            var invoiceType = $("#invoice_type").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:"{{ route('companyProfile.store') }}",
                data:{
                    _token:_token,
                    uid:uid,
                    uname:uname,
                    uphone:uphone,
                    ucountry:ucountry,
                    uvat:uvat,
                    vvat:$("#vvat").val(),
                    email:email,
                    contact_name: contact_name,
                    ship_area:ship_area,
                    location:$("#location").val(),
                    zipcode:$("#zipcode").val(),
                    city:$("#city").val(),
                    invoice_type: invoiceType,
                },
                success:function(data){
                    if(data.status == '2') {
                        Command: toastr["success"]("{{__("Updated the profile")}}", "Success");
                         location.reload(true);
                    } else if(data.status == '1') {
                        Command: toastr["error"]("{{__("Database Error")}}", "Error");
                        return false;
                    }  else if(data.status == '0') {
                        printErrorMsg(data.error);
                        return false;
                    }
                },
                error: function(data) {
                    if(data.status == '401') {
                        Command: toastr["warning"]("{{__("Please login firstly!")}}", "Warning");
                    } else {
                           var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                }
            });
            function printErrorMsg (msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $.each( msg, function( key, value ) {
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    $( ".print-error-msg" ).focus();
                });
            }
          });


          $("#password_btn").click(function() {
            var _token = $("input[name='_token']").val();
            var uid = $('#uid').val();
            var old_password = $('#old_password').val();
            var new_password = $('#new_password').val();
            var confirm_password = $('#confirm_password').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $.ajax({
                type:'POST',
                url:"{{ route('companyProfile.password') }}",
                data:{
                    _token:_token,
                    uid:uid,
                    old_password:old_password,
                    new_password:new_password,
                    confirm_password:confirm_password
                },
                success:function(data){
                    console.log(data);
                    if(data.status == '5') {
                        Command: toastr["error"]("Old {{__('Password')}} Doesn't match!", "Error");
                        return false;
                    }else if(data.status == '2') {
                        Command: toastr["success"]("{{__("Updated the profile")}}", "Success");
                        location.reload(true);
                    } else if(data.status == '1') {
                        Command: toastr["error"]("{{__("Database Error")}}", "Error");
                        return false;
                    }  else if(data.status == '0') {
                        printErrorMsg(data.error);
                        return false;
                    }
                },
                error: function(data) {
                    if(data.status == '401') {
                        Command: toastr["warning"]("{{__("Please login firstly!")}}", "Warning");
                    } else {
                           var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                }
            });
            function printErrorMsg (msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $.each( msg, function( key, value ) {
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    $( ".print-error-msg" ).focus();
                });
            }
          });
        });
        function getCountryCode(value){


            contact_phone = document.getElementById('uphone')

            $(".iti__flag-container").remove();

            window.intlTelInput(contact_phone, {
                initialCountry: value,
                formatOnDisplay: true,
                separateDialCode: true,
                hiddenInput: "contact_full_phone",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                onlyCountries: ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk",
                    "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
                    "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
                    "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"],
            })
        }
        getCountryCode($("#ucountry").find('option:selected').data('country'))

        function verify_vat(value){

            $.post('{{route('company.verify-vat')}}',{'vat': value, '_token' : '{{csrf_token()}}'}, function(data){

                if(data == true){
                    $("#vvat").val('1');
                    $(".update-valid-vat").text('0%');
                    $(".valid_text").text("{{"Valid VAT ID"}}")
                    Command: toastr["success"]("{{__("Valid Vat")}}", "Success");

                }
                else{
                    $("#vvat").val('0');
                    $(".update-valid-vat").text('19%');
                    $(".valid_text").text("{{"Non-valid VAT"}}")
                    Command: toastr["error"]("{{__("Invalid Vat")}}", "Error");
                }
            })
        }
    </script>
@endsection
