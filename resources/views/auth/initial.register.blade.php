@extends('layouts.app')

@section("style")
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<section class="register-section">
    <div class="reg-image col-md-6 col-sm-12" data-aos="zoom-in" data-aos-delay="200">
        <img class="reg-img" src="{{ asset('images/large/Landing/landing-slide.png') }}" alt="main image">
    </div>
    <div class="reg-area col-md-6 col-sm-12" data-aos="zoom-in" data-aos-delay="400">
        <div class="back-btn">
            <a class="back-tag" href="<?= url('/'); ?>">{{ __('Back') }}</a>
        </div>
        <div class="reg-content">
            <form method="POST" class="reg-form" action="{{ route('register') }}">
                @csrf

                <h1 class="form-title fredoka">{{__('Get’s started')}}</h1>
                <p class="form-subtitle">{{__('Please Register to continue with us')}}</p>
                <div class="row reg-input">
                    <input id="name" type="text" class="reg-text form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{__("Full Name")}}">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row reg-input">
                    <input id="email" type="email" class="reg-text form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{__("Email")}}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row reg-input">
                    <input id="password" type="password" class="reg-text form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{__("New Password")}}">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row reg-input">
                    <input id="password-confirm" type="password" class="reg-text form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{__("Confirm Password")}}">
                </div>

                <div class="row reg-input">
                    <button type="submit" class="btn reg-btn">
                        {{ __('Register') }}
                    </button>
                </div>
                <p>{{__('Already have an account? ')}}<a href="{{ route('login') }}" class="login-link">{{__('Login')}}</a></p>
            </form>
        </div>
    </div>
</Section>
<script>
    AOS.init({
        duration: 1200,
    })
</script>
@endsection
