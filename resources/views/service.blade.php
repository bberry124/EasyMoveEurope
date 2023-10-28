@extends("layouts.app")

@section("style")
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section("content")
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('{{ asset('img/EasyMove/B2B client1.png') }}');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2 class="mt-5">{{__('How it works')}}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- ======= Featured Services Section ======= -->
    <section id="featured-services" class="featured-services">
        <div class="container">
            <h2 class="how-title">{{__('How it works')}}</h2>

            <div class="row gy-4">

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up">
                    <div class="number-section">
                        <i class="number-icon fa-solid fa-1"></i>
                    </div>
                    <div class="service-detail">
                        <div class="icon flex-shrink-0"><i class="fas fa-address-card"></i></div>
                        <div>
                            <h4 class="title">{{__('Enter the addresses')}}</h4>

                        </div>
                    </div>
                </div>
                <!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="number-section">
                        <i class="number-icon fa-solid fa-2"></i>
                    </div>
                    <div class="service-detail">
                        <div class="icon flex-shrink-0"><i class="fas fa-hand-holding-usd"></i></div>
                        <div>
                            <h4 class="title">{{__('Get the price instantly')}}</h4>

                        </div>
                    </div>
                </div>
                <!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="number-section">
                        <i class="number-icon fa-solid fa-3"></i>
                    </div>
                    <div class="service-detail">
                        <div class="icon flex-shrink-0"><i class="fas fa-credit-card"></i></div>
                        <div>
                            <h4 class="title">{{__('Book the transport')}}</h4>

                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up">
                    <div class="number-section">
                        <i class="number-icon fa-solid fa-4"></i>
                    </div>
                    <div class="service-detail">
                        <div class="icon flex-shrink-0"><i class="fa-solid fa-box-open"></i></div>
                        <div>
                            <h4 class="title">{{__('Prepare your goods')}}</h4>

                        </div>
                    </div>
                </div>
                <!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="number-section">
                        <i class="number-icon fa-solid fa-5"></i>
                    </div>
                    <div class="service-detail">
                        <div class="icon flex-shrink-0"><i class="fa-solid fa-truck-ramp-box"></i></div>
                        <div>
                            <h4 class="title">{{__('Collection')}}</h4>

                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="number-section">
                        <i class="number-icon fa-solid fa-6"></i>
                    </div>
                    <div class="service-detail">
                        <div class="icon flex-shrink-0"><i class="fa-solid fa-truck"></i></div>
                        <div>
                            <h4 class="title">{{__('Delivery')}}</h4>

                        </div>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>
    </section>
    <!-- End Featured Services Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">

            <div class="row gy-4 align-items-center features-item" data-aos="fade-up">

            <div class="col-md-12">
                <img src="{{ asset('img/EasyMove/van.png') }}" class="img-fluid" alt="">
            </div>

            </div><!-- Features Item -->

            <div class="row gy-4" data-aos="fade-up">
            <div class="col-md-12">
                <h3><b>{{__('For your Company or a Private Move - have a vehicle dedicated to you.')}}</h3></b></p>
                <p>{{ __("Whether it's for your company or a private move, we offer an exclusive van delivery service that caters solely to your cargo.") }}</p>
                <p>{{__('With Easy Move Europe, you can seamlessly move anything across Europe with the convenience of a dedicated van at your disposal.')}}</p>
                <br>

                <h4 style="text-align:left;"><b>{{__('Key Benefits:')}}</b></h4>
                <br>
                <ul class="pull-left" style="text-align:left;">
                    <li><b>{{__('Customized Pick-up and Delivery: ')}}</b>{{__('Say goodbye to rigid schedules! With our dedicated van service, you have the freedom to choose the pick-up and delivery times that suit you best. Enjoy the flexibility that meets your unique requirements.')}}</li>
                    <li><b>{{__("Flexible Timing: ")}}</b>{{__("Need collection or deliveries on weekends, day, or night? We've got you covered! Our van service operates 24/7, ensuring your cargo arrives at its destination precisely when you need it to.")}}</li>
                    <li><b>{{__("Urgent Transports Made Simple: ")}}</b>{{__("When time is of the essence, we're here to help. Take advantage of our same-day collection for urgent transports, ensuring your cargo reaches its destination within 2-3 hours in urban areas.")}}</li>
                    <li><b>{{__('Heavy and Bulky Item Transport: ')}}</b>{{__('Worried about transporting heavy or bulky items? Fear not! Our vans are equipped to handle large and cumbersome cargo, making the process seamless and stress-free.Heavy and Bulky Item Transport: Worried about transporting heavy or bulky items? Fear not! Our vans are equipped to handle large and cumbersome cargo, making the process seamless and stress-free.')}}</li>
                    <li><b>{{__("No Special Packaging Required: ")}}</b>{{__("Unlike other services, we don't require special packaging. Our dedicated van service ensures your items are secure and well-handled without the need for extra packaging materials.")}}</li>
                    <li><b>{{__('Ideal for Fragile Items: ')}}</b>{{__('Delicate items deserve special attention. Trust our dedicated van service to transport fragile items with utmost care, ensuring they reach their destination in perfect condition.')}}</li>
                </ul>
                <p>{{__('With access to an extensive fleet of over 17,000 vans spread across Europe, Easy Move Europe is fully equipped to collect your cargo at your preferred time and deliver it precisely when you need it.')}}</p>
                <p>{{__('Experience the ease and efficiency of our dedicated van delivery service - tailored exclusively for your company or private move. Say goodbye to one-size-fits-all solutions and embrace the convenience of customized transportation.')}}</p>
                <p>{{__('You can hire a dedicated van with driver now and embark on a seamless moving journey across Europe. Let us take care of your cargo while you focus on the things that matter most. Trust Easy Move Europe for all your transportation needs!')}}</p>
            </div>

            </div><!-- Features Item -->

        </div>
    </section>
    <!-- End Features Section -->

</main>
<!-- End #main -->
@endsection
