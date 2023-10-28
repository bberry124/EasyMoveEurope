@extends("layouts.app")

@section("style")
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <style>
        select{
            padding-right: 20px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right center;
        }


        .iti{
            width:100%;
        }
        .error {
            color: red;
        }
        .is-invalid {
            border-color: red;
            background-color: #ffe6e6;
        }


    </style>
@endsection

@section("content")
    <main id="main">
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <form method="POST" class="register-form" id="register_form" autocomplete="off">
                    @csrf
                    <div class="signup-content first-section">
                        <div class="signup-image col-lg-6 col-md-12">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped status-progress" role="progressbar"
                                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:1%">

                                </div>
                            </div>
                            <figure><img class="signup-img" src="{{ asset('img/custom/red-delivery.png') }}"
                                         alt="sing up image"></figure>
                            <a href="/login" class="signup-image-link">{{__('I am already member')}}</a>
                        </div>
                        <div class="signup-form col-lg-6 col-md-12">
                            <h2 class="form-title">{{__('Account Details')}}</h2>
                            <p class="signup-text">{{__('So we know where to contact you')}}</p>
                            <div class="first-section-content">
                                <div class="form-group">
                                    <label for="email"><i class="zmdi zmdi-email"></i></label>
                                    <input type="email" name="email" id="email" placeholder="{{__("Work Email")}}"
                                           autocomplete="off"/>
                                </div>
                                <p class="error-valid" id="email_invalid"><i class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please input your email")}}</p>



                                <div class="form-group">
                                    <label for="company_country"></label>
                                    <select id="company_country" name="company_country" onchange="getCountryCode($(this).find('option:selected').attr('data-country'))"
                                            class="reg-text form-control @error('country') is-invalid @enderror" required>

                                        @foreach(allCountries(1) as $country_key => $country)


                                            <option data-country="{{$country_key}}" value="{{$loop->iteration > 1 ?  $country : $country_key}}" {{$country == old('country') ? 'selected' : ""}}>{{__($country)}}</option>
                                        @endforeach

                                    </select>

                                </div>
                                <p class="error-valid" id="comcountry_invalid"><i
                                        class="zmdi zmdi-alert-circle-o me-1"></i>{{__('Please input company country')}}</p>

                                <div class="form-group">
                                    <label for="work_phone"><i class="zmdi zmdi-phone material-icons-name"></i></label>
                                    <input type="number" name="work_phone" id="work_phone" placeholder="{{__("Work Phone")}}" required
                                           autocomplete="off"/>
                                </div>
                                <p class="error-valid" id="phone_invalid"><i class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please input your phone number")}}</p>



                                <div class="form-group">
                                    <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                    <input type="password" name="password" id="password" placeholder="{{__("Password")}}" required
                                           autocomplete="off"/>
                                </div>
                                <p class="error-valid" id="pass_invalid"><i class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please input password")}}"</p>
                                <div class="form-group">
                                    <label for="password_confirmation"><i class="zmdi zmdi-lock-outline"></i></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           placeholder="{{__("Repeat your password")}}"/>
                                </div>
                                <p class="error-valid" id="repass_invalid"><i class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please input confirmation password")}}</p>
                                <p class="error-valid" id="two_pass_invalid"><i
                                        class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please input confirmation password exactly")}}
                                    </p>

                                <div class="form-group">
                                    <label for="street"><i class="zmdi zmdi-pin"></i></label>
                                    <input type="text" required name="street" id="street"
                                           placeholder="{{__("Street name and number")}}"/>
                                </div>

                                <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                            <label for="zipcode"><i class="zmdi zmdi-pin"></i></label>
                            <input id="zipcode" type="text" name="zipcode" required placeholder="{{__("Zip Code")}}">
                            @error('zipcode')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                            <label for="city"><i class="zmdi zmdi-pin"></i></label>
                            <input id="city" type="text" name="city" required placeholder="{{__("City")}}">
                            @error('city')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        </div>

                                <!-- <div class="form-group">
                                    <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                    <label for="agree-term" class="label-agree-term"><span><span></span></span>{{__('I agree to join Easy Move Europe’s mailing list')}}</a></label>
                                </div> -->
                                <div class="form-group form-button">
                                    <p name="signup" id="first_stepbtn" class="form-submit"><i class="fa fa-arrow-right"
                                                                                               aria-hidden="true"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="signup-content second-section d-none">
                        <div class="signup-image">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped status-progress" role="progressbar"
                                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:35%">

                                </div>
                            </div>
                            <figure><img class="signup-img" src="{{ asset('img/custom/red-delivery.png') }}"
                                         alt="sing up image"></figure>
                            <a href="/login" class="signup-image-link">{{__('I am already member')}}</a>
                        </div>
                        <div class="signup-form">
                            <h2 class="form-title">{{__('Company details')}}</h2>
                            <p class="signup-text">{{__('Enables long-term benefits & VAT deduction')}}</p>
                            <div class="second-section-content">
                                <div class="form-group">
                                    <label for="company_name"><i
                                            class="zmdi zmdi-accounts material-icons-name"></i></label>
                                    <input type="text" name="company_name" id="company_name"
                                           placeholder="{{__("Your Company Name")}}"/>
                                </div>
                                <p class="error-valid" id="comname_invalid"><i
                                        class="zmdi zmdi-alert-circle-o me-1"></i>{{__('Please input company name')}}</p>


                                <div class="form-group">
                                    <label for="contact_name"><i
                                            class="zmdi zmdi-accounts material-icons-name"></i></label>
                                    <input type="text" name="contact_name" id="contact_name"
                                           placeholder="{{__("Your Contact Name")}}"/>
                                </div>
                                <p class="error-valid" id="contact_name_invalid"><i
                                        class="zmdi zmdi-alert-circle-o me-1"></i>{{__('Please input contact name')}}</p>


                                <div class="form-group">
                                    <label for="vat_id"><i
                                            class="zmdi zmdi-shield-security material-icons-name"></i></label>
                                    <input type="text" name="vat_id" id="vat_id"
                                           placeholder="{{__("Your VAT number (eg. PL1234567890)")}}"/>
                                </div>
                                <p class="error-valid" id="vat_invalid_format"><i class="zmdi zmdi-alert-circle-o me-1"></i>{{__('Vat ID not in valid format')}}</p>
                                <p class="error-valid" id="vat_invalid"><i class="zmdi zmdi-alert-circle-o me-1"></i>Please
                                    input VAT ID</p>

                                <div class="form-group">

                                </div>

                                <div class="form-group form-button d-flex justify-content-between">
                                    <p name="signup" id="preceding_stepbtn" class="operbtn form-submit"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i></p>
                                    <p name="signup" id="next_stepbtn" class="operbtn form-submit"><i
                                            class="fa fa-arrow-right" aria-hidden="true"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="signup-content third-section">
                        <div class="signup-image">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped status-progress" role="progressbar"
                                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:70%">

                                </div>
                            </div>
                            <figure><img class="signup-img" src="{{ asset('img/custom/red-delivery.png') }}"
                                         alt="sing up image"></figure>
                            <a href="/login" class="signup-image-link">{{__('I am already member')}}</a>
                        </div>
                        <div class="signup-form">
                            <h2 class="form-title">{{__('Tell us more about your company')}}</h2>
                            <p class="signup-text">{{__('We will use this information to tailor your service experience')}}</p>
                            <div class="third-section-content">
                                <div>
                                    <p>{{__("Your estimated monthly shipments?(optional)")}}</p>
                                    <div class="d-flex justify-content-between">
                                        <div class="col-4 p-3">
                                            <div class="van-item">
                                                <label class="d-flex van-label signup-label" for="to_five">
                                                    <input type="radio" class="btn-check" name="tonumber" value="<=5"
                                                           id="to_five"
                                                           autocomplete="off">
                                                    <p class="label-text">{!!  __(' &lt; 5 ')!!}</p>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4 p-3">
                                            <div class="van-item">
                                                <label class="d-flex van-label signup-label" for="to_twenty">
                                                    <input type="radio" class="btn-check" name="tonumber" value="{{__('5-20')}}"
                                                           id="to_twenty"
                                                           autocomplete="off">
                                                    <p class="label-text">{{__('5-20')}}</p>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4 p-3">
                                            <div class="van-item">
                                                <label class="d-flex van-label signup-label" for="overtwenty">
                                                    <input type="radio" class="btn-check" name="tonumber" value=">=25"
                                                           id="overtwenty"
                                                           autocomplete="off">
                                                    <p class="label-text">{{__(' 25+ ')}}</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p>{{__("Your shipments are mostly? (optional)")}}</p>
                                    <div class="d-flex justify-content-between">
                                        <div class="col-6 p-3">
                                            <div class="van-item">
                                                <label class="d-flex van-label signup-label" for="plane-van">
                                                    <input type="radio" class="btn-check" name="ship_area"
                                                           value="domestic" id="plane-van"
                                                           autocomplete="off">
                                                    <p class="label-text">{{__('Domestic')}}</p>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-6 p-3">
                                            <div class="van-item">
                                                <label class="d-flex van-label signup-label" for="box-van">
                                                    <input type="radio" class="btn-check" name="ship_area"
                                                           value="international" id="box-van"
                                                           autocomplete="off">
                                                    <p class="label-text">{{__('International')}}</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-danger print-error-msg">
                                        <ul></ul>
                                    </div>
                                </div>
                                <div class="form-group form-button d-flex justify-content-between">
                                    <p name="signup" id="preceding_lastbtn" class="operbtn form-submit"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i></p>
                                    <button type="submit" name="signup" id="next_lastbtn" class="operbtn form-submit"><i
                                            class="fa fa-user-plus" aria-hidden="true"></i> {{__("Create")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

    </main>
    <!-- End #main -->

    <script src="{{ asset('js/validation.min.js') }}"></script>
    <script>
        let valid_vat_check = true;
        async function checkValidVat(vat){

           await $.ajax("{{url('checkValidVat')}}" + "/" + vat, {
                success: function (data, status, xhr) {

                    /*          $("#vat_check").text(vat_valid);
                              $("#vat_name").text(vat_name);
                              $("#vat_address").text(vat_address);*/


                    if (data.success == true) {
                        Command: toastr["success"]("Valid Vat Number", "Success");
                        $("#api_status").text("Vat Number");
                    } else {

                        Command: toastr["info"]("Invalid Vat Number", "Info");
                        $("#api_status").text("Invalid Vat Number");
                        valid_vat_check = false;

                    }

                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    Command: toastr["warning"]("Vat Number Error", "Warning");
                    console.log('Error: ' + errorMessage);

                    $("#api_status").text(textStatus);
                    $("#vat_check").text("false");
                    $("#vat_name").text("");
                    $("#vat_address").text("");
                }
            });

        }
        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        $('document').ready(function () {
            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $("#vat_id").on({
                keyup: function(){
                    if($(this).val().length >= 14){
                        $(this).val($(this).val().substring(0, 14));
                    }
                },
                focus: function(){
                    if($(this).val().length >= 14){
                        $(this).val($(this).val().substring(0, 14));
                    }
                }
            });
            $("#first_stepbtn").click(function (e) {
                email = $('#email').val();
                work_phone = $('#work_phone').val();
                password = $('#password').val();
                password_confirmation = $('#password_confirmation').val();

                if (email == '') {
                    $('#email_invalid').show();
                } else {
                    $('#email_invalid').hide();
                }

                if (work_phone == '') {
                    $('#phone_invalid').show();
                } else {
                    $('#phone_invalid').hide();
                }

                if (password == '') {
                    $('#pass_invalid').show();
                } else {
                    $('#pass_invalid').hide();
                }


                if (password_confirmation == '') {
                    $('#repass_invalid').show();
                } else {
                    $('#repass_invalid').hide();
                }

                if (password != '' && password_confirmation != '' && password != password_confirmation) {
                    $('#two_pass_invalid').show();
                } else {
                    $('#two_pass_invalid').hide();
                }

                if (email != '' && work_phone != '' && password != '' && password_confirmation != '' && password == password_confirmation) {
                    $(".first-section").addClass("d-none");
                    $(".second-section").removeClass("d-none");
                    $("#company_name").focus();
                }




            });

            $("#preceding_stepbtn").click(function () {
                $(".first-section").removeClass("d-none");
                $(".second-section").addClass("d-none");
                $("#email").focus();
            });
            $("#next_stepbtn").click(async function () {
                company_name = $('#company_name').val();
                contact_name = $('#contact_name').val();
                company_country = $('#company_country').val();
                vat_id = $('#vat_id').val();

                if (!vat_id.match(/^.{9,14}$/)) {
                    $('#vat_id').val(vat_id.substring(0, vat_id.length - 1));
                    $("#vat_invalid_format").show();
                    return false;
                }
                else{
                    $("#vat_invalid_format").hide();
                }

                // "https://api.vatcheckapi.com/v2/check?vat_number=" + vat_id + "&apikey=gDb7XGSR5OrlnDXwKPIOUR9rq6ZVJGZpBYBNfM5x"

              await checkValidVat(vat_id);


                if (company_name == '') {
                    $('#comname_invalid').show();
                } else {
                    $('#comname_invalid').hide();
                }




                if (contact_name == '') {
                    $('#contact_name_invalid').show();
                } else {
                    $('#contact_name_invalid').hide();
                }
                if (company_country == '') {
                    $('#comcountry_invalid').show();
                } else {
                    $('#comcountry_invalid').hide();
                }

                if (vat_id == '') {
                    $('#vat_invalid').show();
                } else {
                    $('#vat_invalid').hide();
                }

                if (company_name != '' && company_country != '' && vat_id != '' && contact_name != '') {
                    $(".third-section").removeClass("d-none");
                    $(".second-section").addClass("d-none");
                }
            });
            $("#preceding_lastbtn").click(function () {
                $(".third-section").addClass("d-none");
                $(".second-section").removeClass("d-none");
                $("#company_name").focus();
            });

            $("#next_lastbtn").click(function (e) {
                e.preventDefault();

                var _token = $("input[name='_token']").val();
                var email = $('#email').val();
                var work_phone = $('#work_phone').val();
                var password = $('#password').val();
                var password_confirmation = $('#password_confirmation').val();
                var company_name = $('#company_name').val();
                var contact_name = $('#contact_name').val();
                var company_country = $('#company_country').val();
                var vat_id = $('#vat_id').val();
                var api_status = $('#api_status').html();
                var vat_valid = $("#vat_check").html();
                var vat_name = $("#vat_name").html();
                var vat_address = $("#vat_address").html();
                var tonumber = $('input[name="tonumber"]:checked').val();
                var ship_area = $('input[name="ship_area"]:checked').val();

                console.log(api_status);
                console.log(vat_valid);
                console.log(vat_name);
                console.log(vat_address);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('comsignup.create') }}",
                    data: {
                        _token: _token,
                        email: email,
                        work_phone: work_phone,
                        password: password,
                        password_confirmation: password_confirmation,
                        company_name: company_name,
                        company_country: company_country,
                        contact_name:contact_name,
                        vat_id: vat_id,
                        api_status: api_status,
                        vat_valid: vat_valid,
                        vat_name: vat_name,
                        vat_address: vat_address,
                        tonumber: tonumber,
                        ship_area: ship_area,
                        street: $("#street").val(),
                        zipcode: $("#zipcode").val(),
                        city: $("#city").val()
                    },
                    success: function (data) {
                        if (data.status == '2') {
                            Command: toastr["success"]("registered successfully", "Success");
                            setTimeout(() => {
                                window.location.href = "/email/verify";
                            }, "3000")
                            return false;
                        } else if (data.status == '1') {
                            Command: toastr["error"]("{{__("Database Error")}}", "Error");
                            return false;
                        } else if (data.status == '0') {
                            printErrorMsg(data.error);
                            return false;
                        }
                    }
                });

                function printErrorMsg(msg) {
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display', 'block');
                    $.each(msg, function (key, value) {
                        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                        $(".print-error-msg").focus();
                    });
                }
            });
        });
    </script>
    <script>
        function getCountryCode(value){


            contact_phone = document.getElementById('work_phone')

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

        $('#register_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                work_phone: {
                    required: true,
                    minlength: 9
                },
                password: {
                    required: true,
                    minlength: 8
                },
                company_name: {
                    required: true
                },
                company_country: {
                    required: true
                },
                contact_name: {
                    required: true
                },
                vat_id: {
                    required: true
                },
                street: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "{{__('Please input the email address!')}}",
                    email: "{{__('Please input the email address exactly!')}}",
                    maxlength: "{{__('Please input the email address with a maximum of 255 characters!')}}"
                },
                work_phone: {
                    required: "{{__('Please input your phone number!')}}",
                    minlength: "{{__('Please input your phone number with a minimum of 9 characters!')}}"
                },
                password: {
                    required: "{{__('Please input the password!')}}",
                    minlength: "{{__('Please input the password of 8 letters at least!')}}"
                },
                company_name: {
                    required: "{{__('Please input the company name!')}}"
                },
                company_country: {
                    required: "{{__('Please input the company country!')}}"
                },
                contact_name: {
                    required: "{{__('Please input the contact name!')}}"
                },
                vat_id: {
                    required: "{{__('VAT number required')}}"
                },
                street: {
                    required: "{{__('Please input the street!')}}"
                }
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });

    </script>
@endsection
