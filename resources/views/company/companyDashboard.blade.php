@extends('layouts.app')

@section("style")
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
    <section class="container dashboard">
        <div class="dashboard-area">

            @include("partials.companySidebar")

            <div class="db-content col-lg-9 col-md-7 col-sm-12 col-12">
                <div class="db-top">
                    <h3 class="fredoka">
                        {{ Auth::user()->name }}'s {{__("Dashboard")}}
                    </h3>
                    <div class="pull-right">
                        @if(request()->session()->get('user-proxy-id') != null && request()->session()->get('user-proxy-id') != "")
                        <a href="{{url('/user-proxy/exit')}}" class="btn btn-primary btn-md">{{__('Exit user mode')}}</a>
                        @endif
                        <a href="{{url('company/companyQuote/create')}}" class="btn btn-primary btn-md">{{__('New Order')}}</a>
                    </div>
                </div>
                <div class="db-field">
                    <p class="db-subtitle fredoka">{{__('Overview')}}</p>
                    <div class="field-content">
                        <div class="field-boxes">
                            <a href="{{url('company/companyQuote')}}" class="dash-link col-lg-5 col-md-10 col-sm-12 col-12" data-aos="flip-up" data-aos-delay="200">
                                <div class="field-box">
                                    <div class="fbox-image1">
                                        <i class="fa-solid fa-book-open dashboard-upcoming"></i>
                                    </div>
                                    <div class="fbox-text">
                                        <h3 class="fbox-num fredoka upcoming-booking" id="upcoming_count">0</h3>
                                        <p class="fbox-title">{{__('Upcoming Service')}}</p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{url('company/companyPastQuote')}}" class="dash-link col-lg-5 col-md-10 col-sm-12 col-12" data-aos="flip-up" data-aos-delay="400">
                                <div class="field-box">
                                    <div class="fbox-image2">
                                        <i class="fa-solid fa-book dashboard-past"></i>
                                    </div>
                                    <div class="fbox-text">
                                        <h3 class="fbox-num fredoka upcoming-quote" id="past_count">0</h3>
                                        <p class="fbox-title">{{__('Past Service')}}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <br>
                        <br><br><br>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        AOS.init({
            duration: 1200,
        })
    </script>
    <script type="text/javascript">
        $(function () {
            var pastCount = {{$pastCount}};
            var upcomingCount = {{$upcomingCount}};

            if(upcomingCount == '0') {
                $('#upcoming_count').html('0');
            } else {
                $('#upcoming_count').html(upcomingCount);
            }

            if(pastCount == '0') {
                $('#past_count').html('0');
            } else {
                $('#past_count').html(pastCount);
            }
        });
    </script>
@endsection
