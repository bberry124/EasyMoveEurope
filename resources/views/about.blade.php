@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section("content")
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('{{ asset('img/EasyMove/about us 1.jpg') }}');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2 class="mt-5">{{__('About US')}}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- ======= {{__('About US')}} Section ======= -->
    <section id="about" class="about pt-5">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <h2 class="about-title">{{__('About US')}}</h2>
                        <p class="about-text">{{__('Easy Move Europe is an online digital platform that connects companies and private persons to a huge van network, simplifying and making relocation of business and personal assets affordable, through an algorithm that offers prices instantly, with transparency.')}}</p>
                <p class="about-text">{{__('The company was founded with the goal of providing an efficient and reliable transportation service for businesses and individuals in Europe. We are headquartered in Bucharest, RO, and our team of experienced drivers and logistic experts will ensure that your shipment arrives at its destination, safely, securely, and on time.')}}</p>
                <blockquote>
                    <p style="text-align:right;" class="about-text">"{{__('Everything becomes obvious once you know the answer')}}"</p>
                    <footer style="text-align:right;">{{__("James Kaljes (Owner)")}}</footer>
                </blockquote>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End {{__('About US')}} Section -->

    <!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="stats-counter pt-0">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="17000" data-purecounter-duration="5"
                            class="purecounter"></span>
                        <p>{{__('Vans across Europe')}}</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="21" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>{{__('Logistics experts')}}</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="11" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>{{__('Years of experience')}}</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="7108" data-purecounter-duration="3"
                            class="purecounter"></span>
                        <p>{{__('Happy clients')}}</p>
                    </div>
                </div><!-- End Stats Item -->

            </div>

        </div>
    </section><!-- End Stats Counter Section -->

</main>
<!-- End #main -->
@endsection
