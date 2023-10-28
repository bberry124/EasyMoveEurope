@extends("layouts.app")

@section("style")
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section("content")                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               </header>
    <section class="container dashboard">
        <div class="dashboard-area">

            @include("partials.companySidebar")

            <div class="db-content col-lg-9 col-md-7 col-sm-12 col-12">
                <div class="db-top">
                    <h3 class="fredoka">
                        {{ Auth::user()->name }}'s Booking
                    </h3>
                    <!-- <div>
                        <img class="db-img" src="{{ asset('images/small/dashboard/search.png') }}">
                        <img class="db-img" src="{{ asset('images/small/dashboard/notification.png') }}">
                    </div> -->
                </div>
                <div class="db-field">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Upcoming Booking')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Previous Bookings')}}</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            @foreach($services as $key => $data)
                                @if($data->{{__('date ')}}>= now())
                                    <div class="service-card d-flex flex-wrap">
                                        <div class="basic-service col-lg-7 col-md-12 col-sm-12 col-12">
                                            <div class="service-top">
                                                <div class="service-title">
                                                    <p class="fredoka ser-title">{{$data->inspection}}</p>
                                                </div>
                                                <div class="service-date">
                                                    <img class="ser-calendar" src="{{ asset('img/dashboard/calendar.png') }}" alt="calendar image">
                                                    <p class="ser-date">{{$data->date}}</p>
                                                </div>
                                            </div>
                                            <div class="service-area">
                                                <div class="service-content">
                                                    <img class="ser-img" src="{{ asset('img/dashboard/user.png') }}">
                                                    <p class="ser-text">{{$data->name}}</p>
                                                </div>
                                                <div class="service-content">
                                                    <img class="ser-img" src="{{ asset('img/dashboard/call.png') }}">
                                                    <p class="ser-text">{{$data->phone_number}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-service col-lg-5 col-md-12 col-sm-12 col-12">
                                            <div class="post-serarea">
                                                <div class="post-text1">
                                                    <p class="post-title">{{__('Slot time')}}</p>
                                                    @if($data->prefer_time == 'am')
                                                        <p class="post-cost">{{__('9:30am - 11:30am')}}</p>
                                                    @else
                                                        <p class="post-cost">{{__('12:30pm - 2:30pm')}}</p>
                                                    @endif
                                                </div>
                                                <div class="post-text2">
                                                    <p class="post-title">{{__('Registration Number')}}</p>
                                                    <p class="post-cost">{{$data->reg_number}}</p>
                                                </div>
                                                <div class="post-text3">
                                                    <p class="post-title">{{__('Price')}}</p>
                                                    @if($data->inspection == 'Standard')
                                                        <p class="post-cost">€ 99</p>
                                                    @else
                                                        <p class="post-cost">€ 149</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            @foreach($services as $key => $data)
                                @if($data->{{__('date ')}}<= now())
                                    <div class="service-card d-flex flex-wrap">
                                        <div class="basic-service col-lg-7 col-md-12 col-sm-12 col-12">
                                            <div class="service-top">
                                                <div class="service-title">
                                                    <p class="fredoka ser-title">{{$data->inspection}}</p>
                                                </div>
                                                <div class="service-date">
                                                    <img class="ser-calendar" src="{{ asset('img/dashboard/calendar.png') }}" alt="calendar image">
                                                    <p class="ser-date">{{$data->date}}</p>
                                                </div>
                                            </div>
                                            <div class="service-area">
                                                <div class="service-content">
                                                    <img class="ser-img" src="{{ asset('img/dashboard/user.png') }}">
                                                    <p class="ser-text">{{$data->name}}</p>
                                                </div>
                                                <div class="service-content">
                                                    <img class="ser-img" src="{{ asset('img/dashboard/call.png') }}">
                                                    <p class="ser-text">{{$data->phone_number}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-service col-lg-5 col-md-12 col-sm-12 col-12">
                                            <div class="post-serarea">
                                                <div class="post-text1">
                                                    <p class="post-title">{{__('Slot time')}}</p>
                                                    @if($data->prefer_time == 'am')
                                                        <p class="post-cost">{{__('9:30am - 11:30am')}}</p>
                                                    @else
                                                        <p class="post-cost">{{__('12:30pm - 2:30pm')}}</p>
                                                    @endif
                                                </div>
                                                <div class="post-text2">
                                                    <p class="post-title">{{__('Registration Number')}}</p>
                                                    <p class="post-cost">{{$data->reg_number}}</p>
                                                </div>
                                                <div class="post-text3">
                                                    <p class="post-title">{{__('Price')}}</p>
                                                    @if($data->inspection == 'Standard')
                                                        <p class="post-cost">€ 99</p>
                                                    @else
                                                        <p class="post-cost">€ 149</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
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
@endsection
