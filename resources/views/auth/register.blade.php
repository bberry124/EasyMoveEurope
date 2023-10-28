@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/material-icon/css/material-design-iconic-font.min.css') }}">
<link rel="stylesheet" href="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<script src="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <style>
        .iti{
            width:100%;
        }
        select{
            padding-right: 20px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right center;
        }
    </style>
@endsection

@section("content")
<main id="main">
    {{--{{dd(old())}}--}}
    <!-- {{__('Sign up')}} form -->
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">{{__('Sign up')}}</h2>
                    <form method="POST" class="register-form" id="register-form" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input id="name" type="text" class="reg-text form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="{{__("Full Name")}}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input id="email" type="email" class="reg-text form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="{{__("Email")}}">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="country"></label>
                            <select id="country" name="country" onchange="getCountryCode($(this).find('option:selected').attr('data-country'))"
                                    class="reg-text form-control @error('country') is-invalid @enderror" required>

                                @foreach(allCountries(1) as $country_key => $country)


                                    <option data-country="{{$country_key}}" value="{{$loop->iteration > 1 ?  $country : $country_key}}" {{$country == old('country') ? 'selected' : ""}}>{{__($country)}}</option>
                                @endforeach

                            </select>



                            @error('country')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-phone"></i></label>
                            <input id="number" type="text" class="reg-text form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="email" placeholder={{__("PHONE NUMBER")}}>

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <input id="password" type="password" class="reg-text form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="{{__("New Password")}}">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input id="password-confirm" type="password" class="reg-text form-control" name="password_confirmation" autocomplete="new-password" placeholder="{{__("Confirm Password")}}">
                        </div>
                        <div class="form-group">

                            <label for="street"><i class="zmdi zmdi-pin"></i></label>
                            <input id="street" type="text" class="reg-text form-control @error('street') is-invalid @enderror" name="street" value="{{old('street')}}" placeholder="{{__("Street name and number")}}">
                            @error('street')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                            <label for="zipcode"><i class="zmdi zmdi-pin"></i></label>
                            <input id="zipcode" type="text" class="reg-text form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{old('zipcode')}}" placeholder="{{__("Zip Code")}}">
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
                            <input id="city" type="text" class="reg-text form-control @error('city') is-invalid @enderror" name="city" value="{{old('city')}}" placeholder="{{__("City")}}">
                            @error('city')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        </div>
                        <!-- <div class="form-group">
                            <input type="checkbox" name="agree_term" id="agree_term" class="agree-term" />
                            <label for="agree_term" class="label-agree-term">
                                <span><span></span></span>
                                I agree all statements in
                                <a href="/privacy" class="term-service">{{__('Terms of service')}}</a>
                            </label>

                            @error('agree_term')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> -->
                        <div class="form-group form-button">
                            <!-- <input type="submit" name="signup" id="signup" class="form-submit" value="Register" /> -->
                            <button type="submit" class="btn reg-btn">
                                {{ __('Register') }}
                            </button>
                        </div>
                        <p>{{__('Already have an account? ')}}<a href="/login" class="login-link">{{__('Login')}}</a></p>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img class="signup-img" src="{{ asset('img/custom/red-delivery.png') }}" alt="sing up image"></figure>
                    <!-- <a href="/login" class="signup-image-link">{{__('I am already member')}}</a> -->
                </div>
            </div>
        </div>
    </section>

</main>
<script>
    function getCountryCode(value){


        contact_phone = document.getElementById('number')

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
</script>
<!-- End #main -->
@endsection
