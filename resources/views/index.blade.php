@extends("layouts.app")
@section("style")
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        #buttonBlock {padding-right:0px;}

        @media only screen and (max-width: 767px) {
            #buttonBlock {padding-right:20px!important;}
            }
    </style>

@endsection

@section("content")
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">
        <div class="container">
            <div class="row gy-4 d-flex justify-content-between">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h2 data-aos="fade-up">{{__('Van Delivery Service')}}</h2>
                    <h4 data-aos="fade-up" data-aos-delay="100"
                        class="residential_text">{{__('For residential or commercial move,')}}<br/> {{__("hire a exclusive van with driver")}}</h4>
                    <form class="form-search mb-3" data-aos="fade-up" data-aos-delay="200"
                          action="{{ route('price.index') }}" method="get">

                        <div>
                            <div class="d-flex justify-content-between flex-wrap mt-3">
                                <div class="col-md-6 col-12">
                                    <div class="me-1">
                                        <label>{{__("From (Pickup Country)")}}</label>
                                        <div class="d-flex">
                                            <i class="fa-solid fa-location-dot awesome-icon"></i>
                                            <select id="pickup_country" name="pickup_country"
                                                    class="form-control select-country country-input" required>
                                                <option value="">{{__('Type to search')}}</option>
                                                <option value="AT">{{__('Austria')}}</option>
                                                <option value="BE">{{__('Belgium')}}</option>
                                                <option value="BG">{{__('Bulgaria')}}</option>
                                                <option value="HR">{{__('Croatia')}}</option>
                                                <option value="CZ">{{__('Czech Republic')}}</option>
                                                <option value="DK">{{__('Denmark')}}</option>
                                                <option value="EE">{{__('Estonia')}}</option>
                                                <option value="FI">{{__('Finland')}}</option>
                                                <option value="FR">{{__('France')}}</option>
                                                <option value="DE">{{__('Germany')}}</option>
                                                <option value="GR">{{__('Greece')}}</option>
                                                <option value="HU">{{__('Hungary')}}</option>
                                                <option value="IE">{{__('Ireland')}}</option>
                                                <option value="IT">{{__('Italy')}}</option>
                                                <option value="LV">{{__('Latvia')}}</option>
                                                <option value="LT">{{__('Lithuania')}}</option>
                                                <option value="LU">{{__('Luxembourg')}}</option>
                                                <option value="NL">{{__('Netherlands')}}</option>
                                                <option value="NO">{{__('Norway')}}</option>
                                                <option value="PL">{{__('Poland')}}</option>
                                                <option value="PT">{{__('Portugal')}}</option>
                                                <option value="RO">{{__('Romania')}}</option>
                                                <option value="RS">{{__('Serbia')}}</option>
                                                <option value="SK">{{__('Slovakia')}}</option>
                                                <option value="SI">{{__('Slovenia')}}</option>
                                                <option value="ES">{{__('Spain')}}</option>
                                                <option value="SE">{{__('Sweden')}}</option>
                                                <option value="CH">{{__('Switzerland')}}</option>
                                                <option value="GB">{{__('United Kingdom')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="ms-1">
                                        <label>{{__("To (Delivery Country)")}}</label>
                                        <div class="d-flex">
                                            <i class="fa-solid fa-location-dot awesome-icon"></i>
                                            <select id="destination_country" name="destination_country"
                                                    class="form-control select-country country-input" required>
                                                <option value="">{{__('Type to search')}}</option>
                                                <option value="AT">{{__('Austria')}}</option>
                                                <option value="BE">{{__('Belgium')}}</option>
                                                <option value="BG">{{__('Bulgaria')}}</option>
                                                <option value="HR">{{__('Croatia')}}</option>
                                                <option value="CZ">{{__('Czech Republic')}}</option>
                                                <option value="DK">{{__('Denmark')}}</option>
                                                <option value="EE">{{__('Estonia')}}</option>
                                                <option value="FI">{{__('Finland')}}</option>
                                                <option value="FR">{{__('France')}}</option>
                                                <option value="DE">{{__('Germany')}}</option>
                                                <option value="GR">{{__('Greece')}}</option>
                                                <option value="HU">{{__('Hungary')}}</option>
                                                <option value="IE">{{__('Ireland')}}</option>
                                                <option value="IT">{{__('Italy')}}</option>
                                                <option value="LV">{{__('Latvia')}}</option>
                                                <option value="LT">{{__('Lithuania')}}</option>
                                                <option value="LU">{{__('Luxembourg')}}</option>
                                                <option value="NL">{{__('Netherlands')}}</option>
                                                <option value="NO">{{__('Norway')}}</option>
                                                <option value="PL">{{__('Poland')}}</option>
                                                <option value="PT">{{__('Portugal')}}</option>
                                                <option value="RO">{{__('Romania')}}</option>
                                                <option value="RS">{{__('Serbia')}}</option>
                                                <option value="SK">{{__('Slovakia')}}</option>
                                                <option value="SI">{{__('Slovenia')}}</option>
                                                <option value="ES">{{__('Spain')}}</option>
                                                <option value="SE">{{__('Sweden')}}</option>
                                                <option value="CH">{{__('Switzerland')}}</option>
                                                <option value="GB">{{__('United Kingdom')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                        <div class="col-md-8">
                            <div class="row col-md-12" id="CalBlock" style="display:none; margin-bottom:15px;">
                            <table>
                                <tr>
                                    <td>
                                    <div style="border:1px solid #fff; margin-right:20px; margin-left:10px; border-radius:10px; line-height:1.2; padding:0;">
                                    <span style="font-size:9px; color:#fff; display:inline-block; width:100%; margin-bottom:5px;"><span>{{__('average price')}}</span>: <b><span>{{__('companies')}}</span></b></span>
                                    <span style="font-size:18px; font-weight:600; color:#fff; display:inline-block; text-align:right; padding-right:15px; width:100%;"><span id="PriceText1">0</span><span style="padding-left:4px;">&euro;</span></span>
                                    <span style="font-size:9px; color:#767676; display:inline-block; text-align:right; width:100%; padding-right:5px;">(0% VAT)</span>
                                    </div>
                                    </td>
                                    <td>
                                    <div style="border:1px solid #fff; border-radius:10px; line-height:1.2; padding:0; margin-right:20px;">
                                    <span style="font-size:9px; color:#fff; display:inline-block; width:100%; margin-bottom:5px;"><span>{{__('average price')}}</span>: <b><span>{{__('private person')}}</span></b></span>
                                    <span style="font-size:18px; font-weight:600; color:#fff; display:inline-block; text-align:right; padding-right:15px; width:100%;"><span id="PriceText2">0</span><span style="padding-left:4px;">&euro;</span></span>
                                    <span style="font-size:9px; color:#767676; display:inline-block; text-align:right; width:100%; padding-right:5px;">(19% VAT)</span>
                                    </div>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>
                            <div id="buttonBlock" class="submit-button col-md-4">
                                <button type="submit" class="submitbtn btn btn-primary" style="margin-bottom:15px;">{{__('Continue')}}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                    <img src="{{ asset('img/EasyMove/main.png') }}" class="img-fluid mb-3 mb-lg-0" alt="">
                    <div class="row mt-5" data-aos="fade-up" data-aos-delay="400">

                        <div class="col-lg-3 col-6">
                            <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="17000" data-purecounter-duration="5"
                                  class="purecounter"></span>
                                <p>{{__('Vans across Europe')}}</p>
                            </div>
                        </div><!-- End Stats Item -->

                        <div class="col-lg-3 col-6">
                            <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="21" data-purecounter-duration="1"
                                  class="purecounter"></span>
                                <p>{{__('Logistics experts')}}</p>
                            </div>
                        </div><!-- End Stats Item -->

                        <div class="col-lg-3 col-6">
                            <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="11" data-purecounter-duration="1"
                                  class="purecounter"></span>
                                <p>{{__('Years of experience')}}</p>
                            </div>
                        </div><!-- End Stats Item -->

                        <div class="col-lg-3 col-6">
                            <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="7108" data-purecounter-duration="3"
                                  class="purecounter"></span>
                                <p>{{__('Happy clients')}}</p>
                            </div>
                        </div><!-- End Stats Item -->

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Hero Section -->

    <main id="main">

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

        <!-- ======= Call To Action Section ======= -->
        <section id="call-to-action" class="call-to-action">
            <div class="container" data-aos="zoom-out">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="call-title">{{__('For your company or for a private move, the van delivery service is the ideal solution.')}}</h2>
                        <p>
                            "{!! __("You can move anything in Europe with a van dedicated only for your cargo. For your company or for a private move, the van delivery service is the ideal solution.") !!}"
                        </p>
                        <br/>
                        <h4 style="color: white;">{{__('Advantages:')}}</h4>
                        <p>
                            <i class="fa-solid fa-hourglass-half me-2"></i>{{__("Customized pick-up and delivery time- Collection and deliveries on weekends, day and night -Same day collection available for urgent transport")}}
                            <br/>
                            <i class="fa-solid fa-truck me-2"></i>{{__("Transport of heavy and bulky items -No special
                            packaging is required -Ideal for transporting fragile items")}}
                        </p>
                        </dic>
                    </div>

                </div>
        </section>
        <!-- End Call To Action Section -->


        <!-- ======= {{__('Frequently Asked Questions')}} Section ======= -->
        <section id="faq" class="faq">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <span>{{__('Frequently Asked Questions')}}</span>
                    <h2>{{__('Frequently Asked Questions')}}</h2>

                </div>

                <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-lg-10">

                        <div class="accordion accordion-flush" id="faqlist">

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-content-1">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        {{__("Is there any insurance included when I hire the van service?")}}
                                    </button>
                                </h3>
                                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body acc-content">
                                        {{__("Yes, every shipment with our dedicated van delivery is covered by CMR conventions and extended liability is also available (for commercial shipments). The value is currently around 10 euros per kilo and apply to occurrence of theft, damaged goods, gross negligence in international and domestic transport.")}}
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-content-2">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        {{__("Do you have only these two types of vans and measurements?")}}
                                    </button>
                                </h3>
                                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body acc-content">
                                        {{__("No, we have other types, models and sizes of vans. The size you see in the description is an average, sizes may vary. We will always try to maintain the capacity contracted by you (13 and 19 cubic meters), so it is important that you provide us with as much information as possible about your cargo so that we can send you the appropriate van. To transport dangerous items we also have the ADR van and to transport perishable items that need controlled temperature, we have the refrigerated vans, which can be hired separately, just contact us via email or phone and we will provide you with a quote.")}}
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-content-3">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        {{__("Will the driver always help to load/unload the load?")}}
                                    </button>
                                </h3>
                                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body acc-content">
                                        {{__("No, please note that the driver's main focus is driving and he will help load and/or unload the cargo if this is contracted to at the time you hire the transport. Please note that not all drivers are physically able to help, so you need to let us know in advance so that the ideal driver is chosen.")}}
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-content-4">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        {{__("How does the help service work?")}}
                                    </button>
                                </h3>
                                <div id="faq-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body acc-content">
                                        {{__("When you hire the help service, you need to consider that the driver will help to load/unload from the first floor level to the van and vice versa. For cases where loading/unloading is in apartments that do not have an elevator, you need to let us know in advance, as not all drivers are physically able to go up and down stairs.")}}
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-content-5">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        {{__("What can’t be shipped?")}}
                                    </button>
                                </h3>
                                <div id="faq-content-5" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body acc-content">
                                        <span style="font-weight: 600;">{{__('Hazardous goods:')}}</span> {{__("e.g.
                                        firearms,
                                        explosives, ammunition, hazardous materials, radioactives.")}}
                                        <br/>
                                        <span style="font-weight: 600;">{{__('Illegal goods:')}}</span> {{__("Drugs, endangered species, other products illegal under EU laws.")}}
                                        <br/>
                                        <span style="font-weight: 600;">{{__('Livestock:')}}</span> {{__("Live stock animals, horses, pets, mice, worms, insects.")}}
                                        <br/>
                                        <span style="font-weight: 600;">{{__('Money:')}}</span> {{__("Currencies, banknotes and coins.")}}
                                        <br/>
                                        <span style="font-weight: 600;">{{__('Securities:')}}</span> {{__("Bonds, stocks, negotiable documents and all types of securities.")}}
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-content-6">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        {{__("About custom procedures, when should I be concerned and who should take care of it for me?")}}
                                    </button>
                                </h3>
                                <div id="faq-content-6" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body acc-content">
                                        {{__("For transport within the EU, no special documentation is usually required, but when the country of origin or destination is not part of the European Union, the customer always needs to prepare the documentation in advance. Each country has different rules, so you can consult us and we will guide you through this process. In some cases you will be able to prepare the necessary documentation only with our help, but most of the time it is a broker that will carry out this work.")}}
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-content-7">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        {{__("How to pack the goods for shipping?")}}
                                    </button>
                                </h3>
                                <div id="faq-content-7" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body acc-content">
                                        {{__("With the dedicated van delivery, you do not need to package your shipment in any specific way. The shipper is able to accommodate the goods in the van however they like, packed or not. However, note that in the movement of the van on the highway one item can crash into the other causing damage and no one wants that to happen, so we still recommend protecting your goods for transport to avoid damage.")}}
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                        </div>

                    </div>
                </div>

            </div>
        </section>
        <!-- End {{__('Frequently Asked Questions')}} Section -->



        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials">
            <div class="container">

                <div class="slides-1 swiper" data-aos="fade-up">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <h3>{{__('Rodrigo Farias')}}</h3>
                                <h4>{{__('Entrepreneu')}}</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    {!! __("“With our friends of Easy move, we can put our cargo in their hands and focus on our business, as they are reliable and extremely professional.With them, we don't have dissatisfied customers calling us asking where the cargo is or complaining about delays.”") !!}
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <h3>{{__('Ava Williams')}}</h3>
                                <h4>{{__('Client from UK')}}</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    {!! __("“We have already used Easy Move Europe's services 2 times for relocation and each time they have been extremely efficient And always go above and beyond expectations. I have already recommended it to several friends and they are all satisfied.“") !!}
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section>
        <!-- End Testimonials Section -->

       <!-- ======= {{__('About US')}} Section ======= -->
        <section id="about" class="about pt-0">
            <div class="container" data-aos="fade-up">
                <h2 class="about-title">{{__('About US')}}</h2>
                <p class="about-text">{{__('Easy Move Europe is an online digital platform that connects companies and private persons to a huge van network, simplifying and making relocation of business and personal assets affordable, through an algorithm that offers prices instantly, with transparency.')}}</p>
                <p class="about-text">{{__('The company was founded with the goal of providing an efficient and reliable transportation service for businesses and individuals in Europe. We are headquartered in Bucharest, RO, and our team of experienced drivers and logistic experts will ensure that your shipment arrives at its destination, safely, securely, and on time.')}}</p>
                <blockquote>
                    <p style="text-align:right;" class="about-text">"{{__('Everything becomes obvious once you know the answer')}}"</p>
                    <footer style="text-align:right;">{{__("James Kaljes (Owner)")}}</footer>
                </blockquote>
            </div>
        </section>
        <!-- End {{__('About US')}} Section -->

    </main>
    <!-- End #main -->

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            // $(".submitbtn").click(function(event) {
            //     event.preventDefault();

            //     var pickup_text = $("#pickup_country :selected").text();
            //     var pickup_value = $("#pickup_country").val();
            //     var destination_text = $("#destination_country :selected").text();
            //     var destination_value = $("#destination_country").val();

            //     $.ajax({
            //         type:'POST',
            //         url:"{{ route('price.index') }}",
            //         data:{ pickup_text:pickup_text,
            //             pickup_value:pickup_value,
            //             destination_text:destination_text,
            //             destination_value:destination_value
            //         },
            //         success:function(data){
            //             window.location.href = "{{route('price.index')}}"
            //         }
            //     });

            // });

            $("#pickup_country").change(function(){
                let p = $("#pickup_country option:selected").val();
                let d = $("#destination_country option:selected").val();


                if(p !="" && d != ""){
                    let pickup = $("#pickup_country option:selected").text();
                    let destination = $("#destination_country option:selected").text();

                    $.ajax({
                     type:'POST',
                     url:"{{ route('price.calculate_average_price') }}",
                     data:{ pickup:pickup,
                        pickup_code:p,
                        destination:destination,
                        destination_code:d
                     },
                     success:function(data){
                        let companyPrice = data["company_price"];
                        let privatePrice = data["private_price"];

                        $("#PriceText1").text(companyPrice);
                        $("#PriceText2").text(privatePrice);
                        $("#CalBlock").css('display','');
                     }
                });

                }
                else{
                    $("#CalBlock").css('display','none');
                $("#PriceText1").text('0');
                $("#PriceText2").text('0');
                }
            });

            $("#destination_country").change(function(){
                let p = $("#pickup_country option:selected").val();
                let d = $("#destination_country option:selected").val();

                if(p !="" && d != ""){
                    let pickup = $("#pickup_country option:selected").text();
                    let destination = $("#destination_country option:selected").text();

                    $.ajax({
                     type:'POST',
                     url:"{{ route('price.calculate_average_price') }}",
                     data:{ pickup:pickup,
                        pickup_code:p,
                        destination:destination,
                        destination_code:d
                     },
                     success:function(data){
                        let companyPrice = data["company_price"];
                        let privatePrice = data["private_price"];

                        $("#PriceText1").text(companyPrice);
                        $("#PriceText2").text(privatePrice);
                        $("#CalBlock").css('display','');
                     }
                });

                }
                else{
                    $("#CalBlock").css('display','none');
                $("#PriceText1").text('0');
                $("#PriceText2").text('0');
                }
            });

        });
    </script>
@endsection
