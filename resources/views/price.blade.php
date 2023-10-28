@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/price.css?version=0.1') }}">
    <link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="{{ asset('fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
          integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>

        .map-icon-wrapper {
            position: relative;
        }

        .map-icon-wrapper:before {
            content: "";
            background-image: url("{{asset('img/map.png')}}"); /* FontAwesome map icon*/
            width: 20px;
            height: 20px;
            position: absolute;
            right: 10px;
            top: -20px;
            transform: translateY(-50%);
        }


        /* Modal styles */
        .pac-container {
            background-color: #FFF;
            z-index: 20;
            position: fixed;
            display: inline-block;
            float: left;
        }

        .modal {
            z-index: 20;
        }

        .modal-backdrop {
            z-index: 10;
        }
        #search {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
            margin-top: 16px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #search:focus {
            border-color: #4d90fe;
        }

        .title-tip .tooltiptext {
    font-size: 15px;
    font-weight: 400;
    width: 430px;
    position: absolute;
    left: -70px;
    top: -50px;
    background: #000;
    padding: 10px;
    color: #fff;
    visibility: hidden;
}

.title-tip:hover .tooltiptext {
  visibility: visible;
  z-index:999;
}
      .fa-solid.fa-circle-info {
        position: relative;
      }

      .tooltiptext {
        position: absolute;
        font-size: 15px!important;
        font-weight: 500!important;
        font-family: Arial;
        left: 50%;
        transform: translateX(-50%);
        background-color: #fff;
        padding: 10px;
        white-space: normal;
        max-width: 300px;
        z-index: 9999;
        top: calc(100% + 10px); /* Add extra 10px to adjust for spacing */
      }
#pickup_country :nth-child(1) {
  display: none
}

#desti_country :nth-child(1) {
  display: none
}

    </style>
    <script>
        let receiver_map_opened = false;
        let sender_map_opened = false;
        $(function () {
            // Setting IntlTelInput Number
            var receiver_phone = document.querySelector("#receiver_phone");
            var sender_phone = document.querySelector("#sender_phone");
            var contact_phone = document.querySelector("#contact_phone");


            var sender_tel = window.intlTelInput(sender_phone, {
                initialCountry: pickup_country,
                formatOnDisplay: true,

                hiddenInput: "sender_full_phone",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                separateDialCode: true,
                onlyCountries: ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk",
                    "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
                    "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
                    "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"],
            });
            sender_tel.setNumber("{{session('price_page')['sender_phone']  ?? ''}}")


            var receiver_tel = window.intlTelInput(receiver_phone, {
                initialCountry: destination_country,
                formatOnDisplay: true,

                hiddenInput: "receiver_full_phone",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                separateDialCode: true,
                onlyCountries: ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk",
                    "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
                    "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
                    "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"],
            });

            receiver_tel.setNumber("{{session('price_page')['receiver_phone']  ?? ''}}")

            var contact_tel = window.intlTelInput(contact_phone, {
                initialCountry: pickup_country,
                formatOnDisplay: true,
                separateDialCode: true,
                hiddenInput: "contact_full_phone",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                onlyCountries: ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk",
                    "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
                    "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
                    "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"],
            });
            contact_tel.setNumber("{{session('price_page')['contact_phone'] ?? ''}}")
            setTimeout(function () {

                $("#contact_phone").val("{{isset(session('price_page')['contact_phone']) ? session('price_page')['contact_phone'] : ''}}")
            }, 3000)
        })
    </script>
@endsection

@section("content")
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="page-header d-flex align-items-center"
                 style="background-image: url('{{ asset('img/EasyMove/img16.png') }}');">
                <div class="container position-relative">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h2>{{__("Get a price")}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->

        <!-- ======= Get a Quote Section ======= -->
        <section id="get-a-quote" class="get-a-quote">
            <div class="container" data-aos="fade-up">
                <div class="row g-0">

                    <div class="form-wrapper">
                        <form method="post" class="php-email-form">
                            @csrf

                            <div class="d-none">
                                pickup_country<p id="ini_pickup_country" class="">{{$pickup_country}}</P>
                                destination_country<p id="ini_desti_country" class="">{{$destination_country}}</P>
                                <div>
                                    @foreach($pickup_prices as $key => $pickup_price)
                                        pickup_box_price<p id="pickup_box_price"
                                                           class="">{{ $pickup_price->box_min }}</P>
                                        pickup_curtain_price<p id="pickup_curtain_price"
                                                               class="">{{ $pickup_price->curtain_min }}</P>
                                        pickup_short_price<p id="pickup_short_price"
                                                             class="">{{ $pickup_price->short_price }}</P>
                                        pickup_long_price<p id="pickup_long_price"
                                                            class="">{{ $pickup_price->long_price }}</P>
                                    @endforeach
                                </div>
                                <div>
                                    @foreach($destination_prices as $key => $destination_price)
                                        destination_box_price<p id="destination_box_price"
                                                                class="">{{ $destination_price->box_min }}</P>
                                        destination_curtain_price<p id="destination_curtain_price"
                                                                    class="">{{ $destination_price->curtain_min }}</P>
                                        destination_short_price<p id="destination_short_price"
                                                                  class="">{{ $destination_price->short_price }}</P>
                                        destination_long_price<p id="destination_long_price"
                                                                 class="">{{ $destination_price->long_price }}</P>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mt-5 personal-section">
                                <div class="col-12 col-md-6 personal-infos mb-3">
                                    <h2 class="h5"><span>{{__("Pickup Address")}}</span></h2>
                                    <div class="col-12 mt-4">
                                        <label class="form-check-label" for="pickup_country">{{__("COUNTRY")}}</label>
                                        <?php
                                        $ppc =0;
                                        ?>
                                        @foreach($pickup_prices as $key => $pickup_price)
                                        @if($ppc == 0)
                                            <input type="text" name="pickup_country" id="pickup_country"
                                                   value="{{ __($pickup_price->country) }}"
                                                   class="form-control pickup-country"
                                                   placeholder="{{__("Pickup Country")}}"
                                                   disabled>
                                         @endif
                                        <?php $ppc++;?>
                                        @endforeach

                                        <p class="error-valid" id="pickup_country_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please select the country")}}
                                        </p>
                                    </div>
                                    <div class="d-flex">
                                        <div class="col-12 mt-4">
                                            <label class="form-check-label"
                                                   for="sender_city">{{__("FIND THE ADDRESS")}}</label>


                                            <input type="text" value="{{session('price_page')['sender_city'] ?? "" }}"
                                                   name="sender_city"
                                                   id="sender_city" class="form-control pac-target-input"
                                                   placeholder={{__("Start typing your address")}} autocomplete="off">
                                            <div class="map-icon-wrapper">
                                            </div>


                                            <p class="error-valid" id="sender_city_invalid"><i
                                                    class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Start typing your address")}}
                                            </p>
                                        </div>


                                    </div>
                                    <div class="d-flex">
                                        <div class="col-12 mt-4">
                                            <div id="pickup_map"></div>
                                        </div>


                                    </div>
                                    <div class="col-12">
                                        <label class="form-check-label" for="sender">{{__("SENDER")}}</label>
                                        <input type="text" name="sender" id="sender"
                                               value="{{session('price_page')['sender'] ?? "" }}"
                                               class="form-control"
                                               placeholder={{__("Name & Surname")}}>
                                        <p class="error-valid" id="sender_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the sender name")}}
                                        </p>

                                    </div>
                                    <div class="col-12 mt-4 sender-phone-input">
                                        <label class="form-check-label"
                                               for="sender_phone">{{__("PHONE NUMBER")}}</label>
                                        <input type="number" class="form-control" name="sender_phone" id="sender_phone"
                                               placeholder={{__("PHONE NUMBER")}}  value="{{session('price_page')['sender_phone'] ?? "" }}">
                                        <p class="error-valid" id="sender_phone_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the phone number")}}
                                        </p>
                                    </div>
                                    <!-- <div class="col-12 mt-4">
                                        <button type="text" class="form-control" name="sender_btn" id="sender_btn">{{__("Add another collection address")}}</button>
                                    </div> -->
                                </div>
                                <div class="col-12 col-md-6 personal-infos mb-3">
                                    <h2 class="h5"><span>{{__("Delivery Address")}}</span></h2>
                                    <div class="col-12 mt-4">
                                        <label class="form-check-label" for="desti_country">{{__("COUNTRY")}}</label>
                                        <?php $dpc = 0;?>
                                        @foreach($destination_prices as $key => $destination_price)
                                        @if($dpc == 0)
                                            <input type="text" name="desti_country" id="desti_country"
                                                   value="{{__($destination_price->country)}}"
                                                   class="form-control desti-country"
                                                   placeholder="{{__("Destination Country")}}"
                                                   disabled>
                                        @endif
                                        <?php $dpc++;?>
                                        @endforeach

                                        <p class="error-valid" id="desti_country_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please select the country")}}
                                        </p>
                                    </div>
                                    <div class="d-flex">

                                        <div class="col-12 mt-4">
                                            <label class="form-check-label"
                                                   for="receiver_city">{{__("FIND THE ADDRESS")}}</label>


                                            <input value="{{session('price_page')['receiver_city'] ?? "" }}" type="text"
                                                   name="receiver_city"
                                                   id="receiver_city" class="form-control"
                                                   placeholder={{__("Start typing your address")}}>
                                            <div class="map-icon-wrapper">
                                            </div>


                                            <p class="error-valid" id="receiver_city_invalid"><i
                                                    class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Start typing your address")}}
                                            </p>
                                        </div>

                                    </div>
                                    <div class="col-12 mt-4">
                                        <label class="form-check-label" for="receiver">{{__("RECEIVER")}}</label>
                                        <input value="{{session('price_page')['receiver'] ?? "" }}" type="text"
                                               name="receiver" id="receiver"
                                               class="form-control"
                                               placeholder={{__("Name & Surname")}}>
                                        <p class="error-valid" id="receiver_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the receiver name")}}
                                        </p>
                                    </div>
                                    <div class="col-12 mt-4 receiver-phone-input">
                                        <label class="form-check-label"
                                               for="receiver_phone">{{__("PHONE NUMBER")}}</label>
                                        <input value="{{session('price_page')['receiver_phone'] ?? "" }}" type="number"
                                               name="receiver_phone"
                                               class="form-control"
                                               id="receiver_phone" placeholder={{__("PHONE NUMBER")}}>
                                        <p class="error-valid" id="receiver_phone_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the phone number")}}
                                        </p>
                                    </div>

                                </div>

                            </div>
                            <div class="mt-3 van-section">
                                <label class="order-label"
                                       style="margin-bottom: 25px;">{{__("Select Van Type")}}</label>
                                <div class="d-flex flex-wrap van-type-section">
                                    <div class="col-lg-6 col-12 mb-2">
                                        <div class="van-item d-flex justify-content-between px-3">
                                            <label class="d-flex flex-wrap van-label" for="plane_van"
                                                   onclick="tail_show()" onchange="esti_calc()">
                                                <div class="col-md-2 col-4">
                                                    <input
                                                        {{session('price_page')['van_type'] ?? ""  ==  'Curtain Sider' ? 'checked' : ''}} type="radio"
                                                        class="btn-check" name="van_type" value="Curtain Sider"
                                                        id="plane_van" autocomplete="off">
                                                </div>
                                                <div class="col-md-4 col-8">
                                                    <img src="{{ asset('img/icon/large_van.svg') }}" class="me-2"
                                                         height="50" loading="lazy">
                                                </div>
                                                <div class="col-md-5 col-11">
                                                    <h2 class="van-type-text">{{__("Curtain sider")}}</h2>
                                                    <div>
                                                        <p class="van-type-info">{{__("Size:")}} 420 x 210 x 230</p>
                                                        <p class="van-type-info">{{__("Weight: 1000 kg")}}</p>
                                                        <p class="van-type-info">{{__("Capacity: 19 Cubic")}}</p>
                                                    </div>
                                                </div>
                                                <!-- Button trigger modal -->
                                                <div class="col-md-1 col-1">
                                                    <i class="fa-solid fa-circle-info van-info" data-bs-toggle="modal"
                                                       data-bs-target="#van-type-modal"></i>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="van-item d-flex justify-content-between px-3">
                                            <label class="d-flex flex-wrap van-label" for="box_van"
                                                   onclick="tail_hide()" onchange="esti_calc()">
                                                <div class="col-md-2 col-4">
                                                    <input type="radio" class="btn-check"
                                                           {{session('price_page')['van_type'] ?? ""  == 'box' ? 'checked' : ''}} name="van_type"
                                                           value="box"
                                                           id="box_van"
                                                           @if(session('price_page')['van_type'] ?? ""  == null) checked="checked"
                                                           @endif autocomplete="off">
                                                </div>
                                                <div class="col-md-4 col-8">
                                                    <img src="{{ asset('img/icon/small_van.svg') }}" class="me-2" alt=""
                                                         height="50" loading="lazy">
                                                </div>
                                                <div class="col-md-5 col-11">
                                                    <h2 class="van-type-text">{{__("Box")}}</h2>
                                                    <div>
                                                        <p class="van-type-info">{{__("Size:")}} 420 x 175 x 180</p>
                                                        <p class="van-type-info">{{__("Weight: 1000 kg")}}</p>
                                                        <p class="van-type-info">{{__("Capacity: 13 Cubic")}}</p>
                                                    </div>
                                                </div>
                                                <!-- Button trigger modal -->
                                                <div class="col-md-1 col-1">
                                                    <i class="fa-solid fa-circle-info van-info" data-bs-toggle="modal"
                                                       data-bs-target="#van-type-modal"></i>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="order-label">{{__("Extra Services:")}}</label>
                                </div>
                                <div class="service-options d-flex">
                                    <div class="col-md-4 col-12 service-option">
                                        <div class="service-cell"
                                             id="help_loading_card"
                                             aria-checked="{{ isset(session('price_page')['help_loading']) && session('price_page')['help_loading']  === 'true' ? 'true' : 'false'}}"
                                             tabindex="0"
                                             onkeydown="toggleCheckbox(event)"
                                             onclick="toggleCheckbox(event)"
                                             onfocus="focusCheckbox(event)"
                                             onblur="blurCheckbox(event)">

                                            <input type="checkbox"
                                                   {{isset(session('price_page')['help_loading']) &&  session('price_page')['help_loading']  === 'true' ? 'checked' : ""}} name="help_loading"
                                                   value="loading" id="loading"
                                                   class="d-none">
                                            <div class="col-lg-3 col-12 check-image">
                                                <img class="check-img"
                                                     src="{{isset(session('price_page')['help_loading']) && session('price_page')['help_loading'] === 'true' ? asset('img/icon/checkbox-checked-black.png') : asset('img/icon/checkbox-unchecked-black.png')  }}"
                                                     alt="">
                                                <p class="check-text">{{__("70€")}}</p>
                                            </div>
                                            <p class="service-text col-lg-5 col-12">{{__("Driver help - Loading")}}</p>
                                            <img class="flat-img col-lg-4 col-12"
                                                 src="{{ asset('img/icon/delivery-man.png') }}" alt="">
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-12 service-option">
                                        <div class="service-cell"
                                             id="help_unloading_card"
                                             aria-checked="{{isset(session('price_page')['help_unloading']) &&  session('price_page')['help_unloading']   === 'true' ? 'true' : 'false'}}"
                                             tabindex="0"
                                             onkeydown="toggleCheckbox(event)"
                                             onclick="toggleCheckbox(event)"
                                             onfocus="focusCheckbox(event)"
                                             onblur="blurCheckbox(event)">

                                            <input
                                                {{isset(session('price_page')['help_unloading']) && session('price_page')['help_unloading'] === 'true' ? 'checked' : ""}} type="checkbox"
                                                name="help_unloading" value="unloading"
                                                id="unloading" class="d-none">
                                            <div class="col-lg-3 col-12 check-image">
                                                <img class="check-img"
                                                     src="{{isset(session('price_page')['help_unloading']) && session('price_page')['help_unloading'] === 'true' ? asset('img/icon/checkbox-checked-black.png') : asset('img/icon/checkbox-unchecked-black.png')  }}"
                                                     alt="">
                                                <p class="check-text">{{__("70€")}}</p>
                                            </div>
                                            <p class="service-text col-lg-5 col-12">{{__("Driver help - Unloading")}}</p>
                                            <img class="flat-img col-lg-4 col-12"
                                                 src="{{ asset('img/icon/delivery-man (2).png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 service-option" id="tail_lift_item">
                                        <div class="service-cell"
                                             id="help_lift_card"
                                             aria-checked="false"
                                             tabindex="0"
                                             onkeydown="toggleCheckbox(event)"
                                             onclick="toggleCheckbox(event)"
                                             onfocus="focusCheckbox(event)"
                                             onblur="blurCheckbox(event)">

                                            <input
                                                {{isset(session('price_page')['tail_lift']) && session('price_page')['tail_lift'] ===  'tail_lift' ? 'checked' : ""}} type="checkbox"
                                                name="tail_lift" value="tail_lift" id="tail_lift"
                                                class="d-none">
                                            <div class="col-lg-3 col-12 check-image">
                                                <img class="check-img" id="tail_lift_img"
                                                     src="{{ asset('img/icon/checkbox-unchecked-black.png') }}" alt="">
                                                <p class="check-text">{{__("140€")}}</p>
                                            </div>
                                            <p class="service-text col-lg-5 col-12">{{__("Tail Lift")}}</p>
                                            <img class="flat-img col-lg-4 col-12"
                                                 src="{{ asset('img/icon/container.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>

                                <h2 class="h5"><span>{{__("Cargo information")}}</span></h2>
                                <div class="col-12 mt-4">
                                    <label class="form-check-label cargo-label" for="cargo_info">{{__("CARGO")}}</label>
                                    <textarea class="form-control" name="cargo_info" id="cargo_info" rows="3"
                                              placeholder="{{__("Please describe the cargo and enter its approximate dimensions, weight and volume")}}">{{session('price_page')['cargo_info'] ?? "" }}</textarea>
                                    <p class="error-valid" id="cargo_info_invalid"><i
                                            class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the cargo informations")}}
                                    </p>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label class="form-check-label cargo-label" for="cargo_val">{{__("VALUE")}}</label>
                                    <input type="number" name="cargo_val" id="cargo_val" class="form-control"
                                           placeholder="{{__("€")}}"
                                           value="{{session('price_page')['cargo_val'] ?? "" }}">
                                    <p class="error-valid" id="cargo_val_invalid"><i
                                            class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the cargo value")}}
                                    </p>
                                </div>
                                <!-- <div class="col-12 mt-4">
                                    <button type="text" class="form-control" name="receiver_btn" id="receiver_btn">{{__("Add another delivery address")}}</button>
                                </div> -->
                            </div>
                            <div class="row mt-5 contact-area">
                                <h2 class="h5"><span>{{__("Pickup options")}}</span></h2>
                                <p class="desc-text">{{__("When do you want the pickup to take place?")}}</p>
                                <div class="col-md-6 mt-4">

                                    <label class="form-check-label" for="collection_day">{{__("PICK-UP DATE")}}</label>
                                    <input placeholder="{{__("Day of collection")}}" name="collection_day"
                                           class="form-control"
                                           onchange="esti_calc()"
                                           value="{{session('price_page')['collection_day'] ?? "" }}"
                                           type="text" onblur="(this.type='text')"
                                           id="datepicker">
                                    <p class="error-valid" id="collection_day_invalid"><i
                                            class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the pickup date")}}
                                    </p>
                                </div>

                                <h2 class="h5 mt-5">{{__("Contact details")}}</h2>
                                <p class="desc-text">{{__("You will receive an order confirmation on this email address when
                                    you’re done with the payment.")}}</p>
                                @guest
                                    <div class="col-md-4 mt-4">
                                        <label class="form-check-label"
                                               for="contact_name">{{__("NAME & SURNAME")}}</label>
                                        <input type="text" name="contact_name"
                                               value="{{session('price_page')['contact_name'] ?? "" }}"
                                               class="form-control" id="contact_name"
                                               placeholder="{{__("Please enter the contact name")}}">
                                        <p class="error-valid" id="contact_name_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the contact name")}}
                                        </p>
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label class="form-check-label"
                                               for="contact_email">{{__("EMAIL ADDRESS")}}</label>
                                        <input type="email" value="{{session('price_page')['contact_email'] ?? "" }}"
                                               name="contact_email"
                                               class="form-control" id="contact_email"
                                               placeholder="{{__("Please enter the email address")}}">
                                        <p class="error-valid" id="contact_email_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the email address")}}
                                        </p>
                                    </div>
                                    <div class="col-md-4 mt-4 contact-phone-input">
                                        <label class="form-check-label"
                                               for="contact_phone">{{__("PHONE NUMBER")}}</label>
                                        <input name="contact_phone"
                                               value="{{session('price_page')['contact_phone'] ?? "" }}"
                                               class="form-control" type="number"
                                               id="contact_phone" placeholder={{__("PHONE NUMBER")}}>
                                        <p class="error-valid" id="contact_phone_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the phone number")}}
                                        </p>
                                    </div>
                                    {{--  <div class="">
                                          <input type="email" name="user_email" class="form-control" id="user_email"
                                                 placeholder="{{__("User email")}}">
                                          <input type="text" name="user_type" class="form-control" id="user_type"
                                                 placeholder="{{__("User type")}}">
                                          <input type="text" name="user_vat" class="form-control" id="user_vat"
                                                 placeholder="{{__("User Vat")}}">
                                      </div>--}}
                                @else
                                    <div class="col-md-4 mt-4">
                                        <label class="form-check-label"
                                               for="contact_name">{{__("NAME & SURNAME")}}</label>
                                        <input type="text" name="contact_name"
                                               value="{{session('price_page')['contact_name'] ?? "" }}"
                                               class="form-control" id="contact_name"
                                               placeholder="{{ Auth::user()->name }}">
                                        <p class="error-valid" id="contact_name_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the contact name")}}
                                        </p>
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label class="form-check-label"
                                               for="contact_email">{{__("EMAIL ADDRESS")}}</label>
                                        <input type="email" name="contact_email" class="form-control" id="contact_email"
                                               placeholder="{{ Auth::user()->email }}"
                                               value="{{session('price_page')['contact_email'] ?? "" }}">
                                        <p class="error-valid" id="contact_email_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the email address")}}
                                        </p>
                                    </div>
                                    <div class="col-md-4 mt-4 contact-phone-input">
                                        <label class="form-check-label"
                                               for="contact_phone">{{__("PHONE NUMBER")}}</label>
                                        <input name="contact_phone" class="form-control" type="number"
                                               id="contact_phone" placeholder={{__("PHONE NUMBER")}}
                                               value="{{session('price_page')['contact_phone'] ?? "" }}">
                                        <p class="error-valid" id="contact_phone_invalid"><i
                                                class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please enter the phone number")}}
                                        </p>
                                    </div>
                                    {{--      <div class="">
                                              <input type="email" name="user_email" class="form-control" id="user_email"
                                                     value="{{ Auth::user()->email }}"
                                                     placeholder="{{ Auth::user()->email }}">
                                              <input type="text" name="user_type" class="form-control" id="user_type"
                                                     placeholder="{{__("User type")}}" value="{{ Auth::user()->type }}">
                                              <input type="text" name="user_vat" class="form-control" id="user_vat"
                                                     placeholder="{{__("User Vat")}}" value="{{ Auth::user()->vat_valid }}">
                                          </div>--}}
                                @endguest


                                <div class="col-md-12 mt-4">
                                    <label class="form-check-label"
                                           for="contact_note">{{__("SPECIAL NOTES - OPTIONAL")}}</label>
                                    <textarea class="form-control" name="contact_note" id="contact_note" rows="3"
                                              placeholder="{{__("Please put here all your special requests and anything else that you were not able to select in another place. Also, you can inform here your preference about the collection and delivery hours if any")}}">{{session('price_page')['contact_note'] ?? "" }}</textarea>
                                </div>


                                <div class="form-check privacy-area">
                                    <input class="form-check-input privacy-input" type="checkbox" name="term_agree"
                                           value="agreed"
                                           id="term_agree" {{session('price_page')['term_agree'] ?? ""  == 'agreed' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="term_agree">
                                        {{__("I have read and accept the")}} <a href="/privacy"
                                                                                target="_blank">{{__("Terms and Conditions")}}</a> {{__("of Easy Move Europe")}}
                                    </label>
                                    <p class="error-valid" id="term_agree_invalid"><i
                                            class="zmdi zmdi-alert-circle-o me-1"></i>{{__("Please check and accept the terms
                                        and condition")}}</p>
                                </div>

                            </div>
                            <div class="alert alert-danger print-error-msg">
                                <ul></ul>
                            </div>
                            <div class="calculator d-flex flex-wrap" style="border:2px solid #c8c8c8; padding:10px;">
                                <div class="col-md-4 col-4 map_to_remove">
                                    <!-- <button type="button" class="btn esti-btn my-3" onclick="esti_calc()">{{__("Get a price")}}</button> -->
                                    <div class="esti-prices">
                                        <p id="distance_value">{{__("Distance:")}} <span id="distance_val"
                                                                                         class="esti-price"></span></p>
                                        <p id="duration_value">{{__("Duration:")}} <span id="duration_val"
                                                                                         class="esti-price"></span></p>
                                        <p id="price_value" style="position:relative;">{{__("Price:")}} € <span id="price_val"
                                                                                     class="esti-price"></span>
                                                                                     <span class="fa-solid fa-circle-info van-info title-tip title-tip-up" style="font-size:18px; width:20px; height:20px; border-radius:20px; border:1px solid #ccc; position: relative;">
                                                                                         <span class="tooltiptext">
                                                                                             {{ __('The price includes all taxes. If you are a company, please') }} <a href="{{ url('whosignup') }}">{{ __('Open an Account') }}</a> {{ __('or') }} <a href="{{ route('login') }}">{{ __('Login') }}</a> {{ __('to enjoy the tax benefits.') }}
                                                                                         </span>
                                                                                     </span></p>
                                        <div style="width:100%;">
                                        <table style="width:100%;" id="service_footer">
                                            <tr>
                                                <td><span style="font-weight:600; font-size:16px; margin-right:10px;" class="pickup-footer"></span><span class="fa-solid fa-arrow-right" style="margin:0 12px;"></span><span style="font-weight:600; font-size:16px; margin-right:10px;" class="desti-footer"></span></td>
                                            </tr>
                                        </table>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-8 col-8">
                                    <div id="map"></div>
                                </div>


                            <div class="col-md-2 mt-3" id="service_footer2" style="display:none;">
                                <table style="width:100%;" style="display:none;">
                                    <tr style="display:none;">
                                        <td style="max-height:20px; width:45%;"><p style="max-height:20px; margin-bottom:4px;">{{__("From")}}</p></td>
                                        <td style="max-height:20px; width:45%;"></td>
                                        <td style="max-height:20px; width:45%;"><p style="max-height:20px; margin-bottom:4px;">{{__("To")}}</p></td>
                                    </tr>
                                    <tr >
                                        <td><img src="{{ asset('img/icon/location.png')}}" class="location-img" style="text-align:center;"></td>
                                        <td><img src="{{ asset('img/icon/remove.png')}}" class="location-img"></td>
                                        <td><img src="{{ asset('img/icon/location.png')}}" class="location-img" style="text-align:center;"></td>
                                    </tr>
                                    <tr>
                                        <td><h3 class="pickup-footer"></h3></td>
                                        <td></td>
                                        <td><h3 class="desti-footer"></h3></td>
                                    </tr>
                                </table>


                            </div>





                                <!-- <div class="col-md-3 col-sm-6 col-6 measure-cell">
                                    <h3 class="where-country">Distance: <span id="footer_distance" class="esti-price"></span></h3>
                                </div>
                                <div class="col-md-3 col-sm-3 col-3 measure-cell">
                                    <h3>Price: € <span id="footer_price" class="esti-price"></span></h3>
                                </div> -->

                            </div>

                            <div class="row measure-cell" id="createBtnBlock">
                                    <button type="submit" id="submitbtn" class="btn btn-primary col-md-3" style="margin:10px auto;">{{__("Continue")}}</button>
                            </div>

                            <div id="paymentBlock" style="display:none;">
                            <div class="d-flex flex-wrap" style="margin-top:20px;">
                                <span style="font-size:22px; font-weight:700; color:#000;">{{__("How would you like to pay?")}}</span>
                            </div>

                            <div class="row d-flex flex-wrap" style="border:2px solid #c8c8c8; padding:10px; 30px; margin:15px 0px;">
                            <input type="hidden" id="CurrentOrderId" name="CurrentOrderId" value="" />
                            <input type="hidden" id="CurrentOrderNo" name="CurrentOrderNo" value="" />
                            <input type="hidden" id="CurrentPrice" name="CurrentPrice" value="" />
                            <input type="hidden" id="CurrentOrderUrlId" name="CurrentOrderUrlId" value="" />
                            @if ($deferred == "no")
                            <div class="col-md-2"></div>
                            <div class="col-md-4"><input type="button" id="btnBank" class="btn btn-primary btn-lg col-md-11" value="{{__("Bank Transfer")}}" style="background-color:#000; font-size:22px; font-weight:600; border-radius:0; border:1px solid #000;" /></div>
                            <div class="col-md-4"><input type="button" id="btnOnline" class="btn btn-primary btn-lg col-md-11" value="{{__("Credit Card")}}" style="background-color:#000; font-size:22px; font-weight:600; border-radius:0; border:1px solid #000;" /> </div>
                            <div class="col-md-2"></div>
                            @else
                            <div class="col-md-4"><input type="button" id="btnBank" class="btn btn-primary btn-lg col-md-11" value="{{__("Bank Transfer")}}" style="background-color:#000; font-size:22px; font-weight:600; border-radius:0; border:1px solid #000;" /></div>
                            <div class="col-md-4"><input type="button" id="btnOnline" class="btn btn-primary btn-lg col-md-11" value="{{__("Credit Card")}}" style="background-color:#000; font-size:22px; font-weight:600; border-radius:0; border:1px solid #000;" /> </div>
                            <div class="col-md-4"><input type="button" id="btnDeferred" class="btn btn-primary btn-lg col-md-11" value="{{__("Deferred Payment")}}" style="background-color:#000; font-size:22px; font-weight:600; border-radius:0; border:1px solid #000;" /> </div>
                            @endif
                            </div>
                            </div>

                            @guest

                                <div class="col-lg-12" style="font-size: 14px;margin-top:20px; display:none;">
                                    <span style="color:grey">{{__("If you are exempt from paying VAT,")}}</span> <a href="{{url('whosignup')}}"> {{__("Open an
                                        Account")}} </a><span style="color:grey"> {{__("or")}}</span> <a href="{{route('login')}}">{{__(" Login")}}</a> <span style="color:grey">{{__("to enjoy all the
                                    benefits.")}}</span>
                                </div>

                            @endguest
                        </form>

                    </div>

                    <!-- End Quote Form -->
                </div>

            </div>
        </section>
        <!-- End Get a Quote Section -->
        <div id="fix_footer">
            <div class="fix-footer-wrapper container">
                <div class="col-md-2 justify-content-center fix-footer-route">

                    <table style="width:100%;">
                    <tr>
                                            <td style="padding-top:7px;"><span style="font-weight:600; font-size:16px; margin-right:10px;" class="pickup-footer"></span><span class="fa-solid fa-arrow-right" style="margin:0 12px;"></span><span style="font-weight:600; font-size:16px; margin-right:10px;" class="desti-footer"></span></td>
                                        </tr>
                                    <tr style="display:none;">
                                        <td style="max-height:20px; width:45%;"><p class="where-text" style="max-height:20px; margin-bottom:4px;">{{__("From")}}</p></td>
                                        <td style="max-height:20px; width:45%;"></td>
                                        <td style="max-height:20px; width:45%;"><p class="where-text" style="max-height:20px; margin-bottom:4px;">{{__("To")}}</p></td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td><img src="{{ asset('img/icon/location.png')}}" class="location-img" style="text-align:center;"></td>
                                        <td><img src="{{ asset('img/icon/remove.png')}}" class="location-img"></td>
                                        <td><img src="{{ asset('img/icon/location.png')}}" class="location-img" style="text-align:center;"></td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td><h3 class="pickup-footer where-country"></h3></td>
                                        <td></td>
                                        <td><h3 class="desti-footer where-country"></h3></td>
                                    </tr>
                                </table>

            </div>
                <div class="col-md-3 col-6 measure-cell">
                    <h3 class="where-country">{{__("Distance:")}} <span id="fixed_footer_distance"
                                                                        class="esti-price"></span></h3>
                </div>
                <div class="col-md-3 col-6 measure-cell" style="position:relative;">
                    <h3 class="where-country" >{{__("Price:")}} € <span id="fixed_footer_price"
                                                                       class="esti-price"></span>
                                                                       <span class="fa-solid fa-circle-info van-info title-tip title-tip-up" style="font-size:18px; width:20px; height:20px; border-radius:20px; border:1px solid #ccc; position: relative;">
                                                                           <span class="tooltiptext">
                                                                               {{ __('The price includes all taxes. If you are a company, please') }} <a href="{{ url('whosignup') }}">{{ __('Open an Account') }}</a> {{ __('or') }} <a href="{{ route('login') }}">{{ __('Login') }}</a> {{ __('to enjoy the tax benefits.') }}
                                                                           </span>
                                                                       </span>
                                                                       </h3>
                </div>
                <!-- <div class="col-md-3 col-6 measure-cell">
                    <button type="submit" class="submitbtn">{{__("Continue")}}</button>
                </div> -->
            </div>
        </div>
    </main>



    <!-- End #main -->

    <!-- Modal -->
    <div class="modal fade" id="van-type-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-light">
                <div class="modal-body p-3 p-md-2">
                    <div class="d-md-none">
                        <a href="#" class="text-body fw-bold" data-bs-dismiss="modal"
                           style="color: grey; text-decoration: none;">{{__("Close")}}</a>
                        <ul class="nav nav-pills justify-content-between my-3" id="limitsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link btn btn-white active" data-bs-toggle="pill"
                                        data-bs-target="#planeVanTab" role="tab" aria-controls="planeVanTab"
                                        aria-selected="true">
                                    <img src="{{ asset('img/icon/plane-van-big.svg') }}" alt="" loading="lazy">
                                    <span>{{__("Curtain Sider")}}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link btn btn-white" data-bs-toggle="pill"
                                        data-bs-target="#boxVanTab" role="tab" aria-controls="boxVanTab"
                                        aria-selected="false">
                                    <img src="{{ asset('img/icon/box-van-big.svg') }}" alt="" loading="lazy">
                                    <span>{{__("Box van")}}</span>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="planeVanTab" role="tabpanel">
                                <div class="card shadow-lg">
                                    <div class="card-body small">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('img/icon/load-size.svg') }}" alt="" class="me-2"
                                                         loading="lazy">
                                                    <span>{{__("Max load size")}} (cm)</span>
                                                </td>
                                                <td>{{__("420 x 210 x 230")}}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('img/icon/weight.svg') }}" alt="" class="me-2"
                                                         loading="lazy">
                                                    <span>{{__("Max weight")}} (kg)</span>
                                                </td>
                                                <td>{{__("1000")}}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('img/icon/capacity.svg') }}" alt="" class="me-2"
                                                         loading="lazy">
                                                    <span>{{__("Capacity (m")}}<sup>3</sup>{{__(")")}}</span>
                                                </td>
                                                <td>{{__("19")}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill my-4"
                                                data-bs-toggle="collapse" data-bs-target="#planeVanLayout"
                                                aria-expanded="false"
                                                aria-controls="planeVanLayout">{{__("Show van layout")}}
                                        </button>
                                        <div class="collapse van-layout p-4" id="planeVanLayout">
                                            <button type="button" class="btn-close float-end" data-bs-toggle="collapse"
                                                    data-bs-target="#planeVanLayout" aria-label="Close">

                                            </button>
                                            <img src="{{ asset('img/icon/plane-van-details.png') }}" alt=""
                                                 class="img-fluid" loading="lazy"
                                                 data-xblocker="passed" style="visibility: visible;">
                                        </div>
                                        <p class="fw-bold text-uppercase">{{__("Curtain Sider is best for:")}}</p>
                                        <ul>
                                            <li>{{__("Pallet shipment / custom loads")}}</li>
                                            <li>{{__("Rear loading / side loading")}}</li>
                                        </ul>
                                        <div class="d-flex">
                                            <i class="fa-solid fa-circle-info"
                                               style="margin: 5px 10px; color: green;"></i>
                                            <p style="color: grey;"><span
                                                    style="font-weight: 600;">{{__("Curtain-Side van + Tail Lift:")}}</span>{{__("Total capacity is 700kg (due the lift weight)")}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="boxVanTab" role="tabpanel">
                                <div class="card shadow-lg">
                                    <div class="card-body small">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td><img src="{{ asset('img/icon/load-size.svg') }}" alt="" class="me-2"
                                                         loading="lazy">
                                                    <span>{{__("Max load size")}} (cm)</span>
                                                </td>
                                                <td>{{__("420 x 175 x 180")}}</td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{ asset('img/icon/weight.svg') }}" alt="" class="me-2"
                                                         loading="lazy">
                                                    <span>{{__("Max weight")}} (kg)</span>
                                                </td>
                                                <td>{{__("1000")}}</td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{ asset('img/icon/capacity.svg') }}" alt="" class="me-2"
                                                         loading="lazy">
                                                    <span>{{__("Capacity (m")}}<sup>3</sup>{{__(")")}}</span>
                                                </td>
                                                <td>{{__("13")}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill my-4"
                                                data-bs-toggle="collapse" data-bs-target="#boxVanLayout"
                                                aria-expanded="false"
                                                aria-controls="boxVanLayout">{{__("Show van layout")}}
                                        </button>
                                        <div class="collapse van-layout p-4" id="boxVanLayout">
                                            <button type="button"
                                                    class="btn-close float-end" data-bs-toggle="collapse"
                                                    data-bs-target="#boxVanLayout" aria-label="Close">
                                            </button>
                                            <img src="{{ asset('img/icon/box-van-details.png') }}" alt=""
                                                 class="img-fluid" loading="lazy"
                                                 data-xblocker="passed" style="visibility: visible;">
                                        </div>
                                        <p class="fw-bold text-uppercase">{{__("Box van is best for:")}}</p>
                                        <ul>
                                            <li>{{__("High-value items requiring additional security measures (e.g. electronics, luxury)")}}
                                            </li>
                                            <li>{{__("Rear loading")}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="my-2 ms-3"><a href="#" class="text-body fw-bold"
                                                  data-bs-dismiss="modal">{{__("Close")}}</a>
                        </div>
                        <div class="row g-2 py-2 text-uppercase text-center heading" style="font-size: 12px;">
                            <div class="col-4 ps-5 text-start">{{__("Type")}}</div>
                            <div class="col-2"><img src="{{ asset('img/icon/load-size.svg') }}" alt="" loading="lazy">
                                <span>{{__("Max load size")}}
                                (cm)</span></div>
                            <div class="col-2"><img src="{{ asset('img/icon/weight.svg') }}" alt="" loading="lazy">
                                <span>{{__("Max weight")}}
                                (kg)</span></div>
                            <div class="col-2"><img src="{{ asset('img/icon/capacity.svg') }}" alt="" loading="lazy">
                                <span>{{__("Capacity (m")}}<sup>3</sup>)</span></div>
                        </div>
                        <div class="accordion" id="limitsAccordion">
                            <div class="accordion-item shadow">
                                <div class="accordion-header">
                                    <button
                                        class="accordion-button fs-7 fs-xl-6 text-center collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#planeVanCollapse"
                                        aria-expanded="false"
                                        aria-controls="planeVanCollapse">
                                        <div class="col-4 text-start"><img
                                                src="{{ asset('img/icon/plane-van-big.svg') }}"
                                                alt="" class="me-4" loading="lazy"> <strong class="text-primary">{{__("Curtain Sider")}}</strong>
                                         </div>
                                        <div class="col-2">{{__("420 x 210 x 230")}}</div>
                                        <div class="col-2">{{__("1000")}}</div>
                                        <div class="col-2">{{__("19")}}</div>
                                    </button>
                                </div>
                                <div id="planeVanCollapse" class="accordion-collapse collapse"
                                     data-bs-parent="#limitsAccordion" style="">
                                    <div class="accordion-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-7 mb-2"><img
                                                    src="{{ asset('img/icon/plane-van-details.png') }}" alt=""
                                                    class="img-fluid" loading="lazy" data-xblocker="passed"
                                                    style="visibility: visible;"></div>
                                            <div class="col-md-5">
                                                <div class="card border-1">
                                                    <div class="card-body">
                                                        <p class="fw-bold text-uppercase">{{__("Curtain Sider is best for:")}}</p>
                                                        <ul>
                                                            <li>{{__("Pallet shipment / custom loads")}}</li>
                                                            <li>{{__("Rear loading / side loading")}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item shadow">
                                <div class="accordion-header">
                                    <button
                                        class="accordion-button fs-7 fs-xl-6 text-center collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#boxVanCollapse" aria-expanded="false"
                                        aria-controls="boxVanCollapse">
                                        <div class="col-4 text-start"><img src="{{ asset('img/icon/box-van-big.svg') }}"
                                                                           alt="" class="ms-2 me-5" loading="lazy">
                                            <strong class="text-primary">{{__("Box van")}}</strong>
                                        </div>
                                        <div class="col-2">{{__("420 x 175 x 180")}}</div>
                                        <div class="col-2">{{__("1000")}}</div>
                                        <div class="col-2">{{__("13")}}</div>
                                    </button>
                                </div>
                                <div id="boxVanCollapse" class="accordion-collapse collapse"
                                     data-bs-parent="#limitsAccordion" style="">
                                    <div class="accordion-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-7 mb-2"><img
                                                    src="{{ asset('img/icon/box-van-details.png') }}" alt=""
                                                    class="img-fluid" loading="lazy" data-xblocker="passed"
                                                    style="visibility: visible;"></div>
                                            <div class="col-md-5">
                                                <div class="card border-1">
                                                    <div class="card-body">
                                                        <p class="fw-bold text-uppercase">{{__("Box van is best for:")}}</p>
                                                        <ul>
                                                            <li>{{__("High-value items requiring additional security measures (e.g. electronics, luxury)")}}</li>
                                                            <li>{{__("Rear loading")}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pickupMapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-light">
                <div class="modal-body p-3 p-md-2">
                    <input id="search" type="text" placeholder="{{__("Search for location")}}">
                    <div id="pickup_maps" style="height: 400px;">


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Close")}}</button>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="vatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__("VAT Exemption")}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                            style="color: grey; text-decoration: none;" aria-label="Close">
                        <span aria-hidden="true">{{__("&times;")}}</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{__("If your company has VAT exemption and need a personalized invoice, we recommend to registering or login first")}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</button>

                </div>
            </div>
        </div>
    </div>



    {{--<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
  <div class="panel panel-default">
    <div class="panel-heading d-flex justify-content-around">
      <div class="row text-center">
        <h3 class="panel-heading">{{__('Payment Details')}}</h3>
      </div>
      <div class="display-td">
        <img class="img-responsive strip-img pull-right" src="{{ asset('img/custom/PngItem_2918799.png') }}">
      </div>
    </div>
    <div class="panel-body">

      @if (Session::has('success'))
      <div class="alert alert-success text-center">
        <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-info"
            aria-hidden="true"></i></a>
        <p>{{ Session::get('success') }}</p>
      </div>
      @endif

      <form role="form" action="{{ route('stripe.payment') }}" method="post" class="validation"
        data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
        @csrf

        <div class='form-row row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>{{__('Name on Card')}}</label>
            <input class='form-control' size='4' type='text'>
          </div>
        </div>

        <div class='form-row row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>{{__('Card Number')}}</label>
            <input autocomplete='off' class='form-control card-num' size='20' type='text'>
          </div>
        </div>

        <div class='form-row row'>
          <div class='col-xs-12 col-md-4 form-group cvc expiration required'>
            <label class='control-label'>{{__('CVC')}}</label>
            <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4' type='text'>
          </div>
          <div class='col-xs-12 col-md-4 form-group expiration required'>
            <label class='control-label'>{{__('Expiration Month')}}</label>
            <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
          </div>
          <div class='col-xs-12 col-md-4 form-group expiration required'>
            <label class='control-label'>{{__('Expiration Year')}}</label>
            <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
          </div>
        </div>

        <div class='form-row row'>
          <div class='col-md-12 error-text error form-group'>
            <div class='alert-danger alert'>{{__('Fix the errors before you begin.')}}</div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <button class="btn btn-danger btn-lg btn-block" type="submit">{{__("Pay Now")}}
              (€{{ request()->get('price') }})</button>
          </div>
        </div>
          <div id="payment-request-button">
              <!-- A Stripe Element will be inserted here. -->
          </div>

      </form>
    </div>
  </div>
</div>
<div class="col-md-6 col-md-offset-3 payment-image">
  <img src="{{ asset('img/EasyMove/img17.png')}}" class="payment-img" alt="Payment Image">
</div>
</div>
</div>--}}

    <!-- JS -->
    <script>
        $(document).ready(function () {
            if ($(window).width() <= 767) {
                document.getElementById("map").style.display = "none";
                $(".map_to_remove").removeClass("col-4").addClass("col-12");
            }

            var user_type = $('#user_type').val();
            if (user_type == '') {
                $("#person_user").prop('checked', true);
            } else if (user_type == 'user') {
                $("#person_user").prop('checked', true);
            } else if (user_type == 'company') {
                $("#company_user").prop('checked', true);
            }

            $('#pickup_country:eq(1)').hide();
            $('#desti_country:eq(1)').hide();

        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('js/datepicker.js?version='.time())}}"></script>
    <script src="{{asset('js/fixed-footer.js')}}"></script>

    <script>
        // google.maps.event.addDomListener(window, 'load', initialize);
        // google.maps.event.addDomListener(window, 'load', initMap);

        $("#sender_city").blur(function () {

            setTimeout(() => {
                esti_calc('sender');
            }, 1000);

        });
        $("#receiver_city").blur(function () {
            setTimeout(() => {
                esti_calc('receiver');
            }, 1000);
        });

        // Show/Hide the Tail-Lift item
        function tail_show() {
            $("#tail_lift_item").css("display", "block");
        }

        function tail_hide() {
            $("#tail_lift_item").css("display", "none");
        }

        // Setting the pickup and destination country
        var iniPickup = $("#pickup_country").val();
        var iniDesti = $("#desti_country").val();

        // var iniPickup = $("#pickup_country option:selected").text();
        // var iniDesti = $("#desti_country option:selected").text();


        $(".pickup-footer").text(iniPickup);
        $(".desti-footer").text(iniDesti);


        var changePickup;
        var pickup_country, destination_country;

        /*       function pickupFunction(sel) {
        changePickup = sel.options[sel.selectedIndex].text;
        pickup_country = sel.options[sel.selectedIndex].value;
        $(".pickup-footer").text(changePickup);
        initialize();
        intlTelInput();
        }

        function destiFunction(sel) {
        changeDesti = sel.options[sel.selectedIndex].text;
        destination_country = sel.options[sel.selectedIndex].value;
        $(".desti-footer").text(changeDesti);
        initialize();
        intlTelInput();
        }
        */

        // Google Map API Setting
        /*google.maps.event.addDomListener(window, 'load', initialize);*/

        pickup_country = $("#ini_pickup_country").html();
        destination_country = $("#ini_desti_country").text();

        function initialize() {
            try {
                var options_pickup = {
                    types: ['address'],
                    componentRestrictions: {country: pickup_country}
                };
                var options_desti = {
                    types: ['address'],
                    componentRestrictions: {country: destination_country}
                };
                var pickup_location = document.getElementById('sender_city');
                var destination_location = document.getElementById('receiver_city');
                try {
                    var autocomplete_pick = new google.maps.places.Autocomplete(pickup_location, options_pickup);
                    var autocomplete_desti = new google.maps.places.Autocomplete(destination_location, options_desti);

                    autocomplete_pick.addListener('place_changed', function () {
                        try {
                            var first_place = autocomplete_pick.getPlace();
                        } catch (except) {
                            console.log('afddffderrbhi')
                        }

                    });
                    autocomplete_desti.addListener('place_changed', function () {

                        var second_place = autocomplete_desti.getPlace();

                    });
                } catch (except) {
                    console.log('afddffderrbhi')
                }

            } catch (except) {
                console.log('abhi')
            }


        }
    </script>

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcUccmFJ_K2m8gV048ha6eoHtfx1XMZPc&libraries=places&v=weekly&callback=initialize"></script>
    <script>

        let duration = "";

        function esti_calc(input_type = 'sender') {
            try {
                var pickup_location = document.getElementById("sender_city").value;
                var destination_location = document.getElementById("receiver_city").value;

                if (pickup_location == '' || destination_location == '') {
                    Command: toastr["info"]("{{__("Please type a pickup & destination addresses!")}}", "Info");
                    return;
                }


                const directionsService = new google.maps.DirectionsService();

                directionsService.route(
                    {
                        origin: pickup_location,
                        destination: destination_location,
                        travelMode: "DRIVING",
                    },
                    (response, status) => {
                        if (status === "OK") {


                            new google.maps.DirectionsRenderer({
                                suppressMarkers: true,
                                directions: response,
                                map: map,
                            });
                        } else if (status === google.maps.DirectionsStatus.UNKNOWN_ROUTE) {

                            return false;
                        } else {
                            // Handle other errors
                            return false;
                        }
                    }
                )

                var service = new google.maps.DistanceMatrixService();
                service.getDistanceMatrix(
                    {
                        origins: [pickup_location],
                        destinations: [destination_location],
                        travelMode: 'DRIVING',
                    }, callback);
                let show_map = false;

                async function callback(response, status) {
                    try {

                        if (status == 'OK') {
                            var origins = response.originAddresses;
                            var destinations = response.destinationAddresses;

                            for (var i = 0; i < origins.length; i++) {
                                var results = response.rows[i].elements;
                                for (var j = 0; j < results.length; j++) {
                                    var element = results[j];
                                    if (element.status !== 'NOT_FOUND') {


                                        try {
                                            var distance = element.distance.text;
                                            var distance_value = element.distance.value;


                                            var from = origins[i];
                                            var to = destinations[j];
                                        } catch (expect) {
                                            return false;
                                            /* console.log(expect);
                                             if (input_type == 'sender')
                                                 geoMaps($("#sender_city").val())
                                             else
                                                 geoMaps($("#receiver_city").val(), input_type)*/
                                        }
                                    } else {

                                        show_map = true;


                                    }


                                }
                            }
                            if (show_map === true) {
                                if (input_type == 'sender') {
                                    if (sender_map_opened == false) {
                                        $("#sender_city").siblings('.map-icon-wrapper').click()
                                        sender_map_opened = true
                                    }
                                } else {
                                    if (receiver_map_opened == false) {
                                        $("#receiver_city").siblings('.map-icon-wrapper').click()
                                        receiver_map_opened = true
                                        }
                                }

                            }
                            if (element.status !== 'NOT_FOUND') {

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                await $.post('{{route('price.calculate_price')}}', {duration: distance}, function (data) {
                                    let arr = data.split(" ");
                                    duration = arr[0] + " " + arr[1];
                                    //duration = data;
                                })
                            }

                        } else {
                            return false;
                        }


                        var pickup_country = $('#pickup_country').val();
                        var desti_country = $('#desti_country').val();

                        var pickup_box_price = $('#pickup_box_price').html();
                        var pickup_curtain_price = $('#pickup_curtain_price').html();
                        var pickup_short_price = $('#pickup_short_price').html();
                        var pickup_long_price = $('#pickup_long_price').html();

                        var destination_box_price = $('#destination_box_price').html();
                        var destination_curtain_price = $('#destination_curtain_price').html();
                        var destination_short_price = $('#destination_short_price').html();
                        var destination_long_price = $('#destination_long_price').html();

                        var iniPickup = $("#pickup_country option:selected").text();
                        var iniDesti = $("#desti_country option:selected").text();
                        var van_type = $("input[name='van_type']:checked").val();
                        if (distance) {
                            var rest_distance = parseFloat(distance.replace(/[^\d.-]/g, ''));


                            rest_distance -= 500;


                            var collection_day = $('#datepicker').val();
                            var today = new Date();


                            var d = today.getDate();
                            var m = today.getMonth() + 1;
                            var y = today.getFullYear();

                            today = (d <= 9 ? '0' + d : d) + '/' + (m <= 9 ? '0' + m : m) + '/' + y;


                            var loading_checked = $("#help_loading_card").attr("aria-checked");
                            var unloading_checked = $("#help_unloading_card").attr("aria-checked");
                            var lift_checked = $("#help_lift_card").attr("aria-checked");

                            var van_type_checked = $('input[name="van_type"]:checked').val();

                            if (van_type_checked == "box") {
                                $("#help_lift_card").attr("aria-checked", "false");
                                $("#tail_lift_img").attr("src", "img/icon/checkbox-unchecked-black.png");
                            }


                            if (van_type == 'box') {
                                if (parseInt(pickup_box_price) == parseInt(destination_box_price)) {
                                    var min_price = pickup_box_price;

                                } else if (parseInt(pickup_box_price) > parseInt(destination_box_price)) {


                                    var min_price = pickup_box_price;

                                } else if (parseInt(pickup_box_price) < parseInt(destination_box_price)) {
                                    var min_price = destination_box_price;

                                }
                            } else if (van_type == 'Curtain Sider') {
                                if (parseInt(pickup_curtain_price) == parseInt(destination_curtain_price)) {
                                    var min_price = pickup_curtain_price;
                                } else if (parseInt(pickup_curtain_price) > parseInt(destination_curtain_price)) {
                                    var min_price = pickup_curtain_price;
                                } else if (parseInt(pickup_curtain_price) < parseInt(destination_curtain_price)) {
                                    var min_price = destination_curtain_price;
                                }
                            }


                            if (distance_value < '500000') {
                                var real_price = min_price;
                                console.log('distance_value < 500000 ' + real_price);
                            } else if (distance_value > '1000000') {
                                var add_price = rest_distance * 0.93;
                                var real_price = (Number(min_price) + Number(add_price)).toFixed(2);
                                console.log('distance_value > 1000000 ' + real_price + ' min price is ' + min_price + " add_price is " + add_price);
                            } else if ('500000' < distance_value < '1000000') {
                                var add_price = rest_distance * 1.03;
                                var real_price = (Number(min_price) + Number(add_price)).toFixed(2);

                                console.log('500000 < distance_value < 1000000 ' + real_price);
                            }


                            if (pickup_country == desti_country) {
                                var real_price = Number(real_price) + 110;

                                console.log("pickup_country " + real_price);
                            }


                            if (loading_checked == "true") {
                                var real_price = Number(real_price) + 70;

                                console.log("loading_checked " + real_price);
                            }

                            if (unloading_checked == "true") {
                                var real_price = Number(real_price) + 70;

                                console.log("unloading_checked " + real_price);
                            }

                            if (lift_checked == "true") {
                                var real_price = Number(real_price) + 140;

                                console.log("lift_checked " + real_price);
                            }

                            if (collection_day == today) {
                                var real_price = Number(real_price) + 80;

                                console.log('collection_day ' + real_price);
                            }

                            let dateStrings = collection_day;
                            let dateArr = dateStrings.split("/");
                            let day = dateArr[0];
                            let month = dateArr[1] - 1; // months in javascript are zero indexed
                            let year = dateArr[2];
                            let date = new Date(year, month, day);
                            var weekend_day = new Date(date);

                            if (weekend_day.getDay() == 6 || weekend_day.getDay() == 0) {
                                var real_price = Number(real_price) + 110;
                                console.log("6");
                                console.log('week_end ' + real_price);
                            }

                            var real_price = Number(real_price).toFixed(2);


                            @if (!auth()->check())
                                vat_add = (real_price * 19) / 100;
                            real_price = parseFloat(real_price) + vat_add;
                            real_price = real_price.toFixed(2);
                            //real_price += " <i style='font-weight: 500;font-size: 12px;'>(Included VAT 19%)</i>";

                            @endif
                                @if (auth()->check() &&  auth()->user()->vat_check() == false)
                                vat_add = (real_price * 19) / 100;
                            real_price = parseFloat(real_price) + vat_add;
                            real_price = real_price.toFixed(2);
                            real_price += " <i style='font-weight: 500;font-size: 12px;'>(Included VAT 19%)</i>";

                            @endif


                            document.getElementById("distance_val").innerHTML = distance;
                            document.getElementById("fixed_footer_distance").innerHTML = distance;
                            document.getElementById("duration_val").innerHTML = duration;
                            document.getElementById("price_val").innerHTML = real_price;
                            document.getElementById("fixed_footer_price").innerHTML = real_price;
                        }
                    } catch (except) {
                        console.log('awereou')
                    }

                }

            } catch (except) {
                console.log('dfdffddf')
            }

        }

        const map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(46.03, 14.30),
            zoom: 3,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        });


    </script>

    <script>
        function toggleCheckbox(event) {

            var node = event.currentTarget
            var image = node.getElementsByTagName('img')[0]

            var state = node.getAttribute('aria-checked').toLowerCase()

            if (event.type === 'click' || (event.type === 'keydown' && event.keyCode === 32)) {
                if (state === 'true') {
                    node.setAttribute('aria-checked', 'false')
                    image.src = '{{ asset('img/icon/checkbox-unchecked-black.png') }}'
                } else {
                    node.setAttribute('aria-checked', 'true')
                    image.src = '{{ asset('img/icon/checkbox-checked-black.png') }}'
                }

                event.preventDefault()
                event.stopPropagation()
            }
            esti_calc();
        }

        function focusCheckbox(event) {
            event.currentTarget.className += ' focus'
        }

        function blurCheckbox(event) {
            event.currentTarget.className = event.currentTarget.className.replace(' focus', '')
        }
    </script>

    <script>


        let marker;

        async function geoMaps(value, input_type = 'sender') {

            try {
                console.log(input_type)
                let lat;
                let lng;

                const url = new URL("https://maps.googleapis.com/maps/api/geocode/json");
                url.searchParams.append("address", input_type == 'sender' ? '{{$pickup_prices[0]->country}}' : '{{$destination_prices[0]->country}}');
                url.searchParams.append("key", "AIzaSyDcUccmFJ_K2m8gV048ha6eoHtfx1XMZPc");
                const response = await fetch(url);
                if (response.ok) {
                    const result = await response.json();
                    var location = result.results[0].geometry.location;
                    lat = location.lat;
                    lng = location.lng;

                } else {
                    return;
                }


                /*    await  $.ajax({
                          url: "https://maps.googleapis.com/maps/api/geocode/json",
                          data: {
                              address: "capital " + countryCode,
                              key: "YOUR_API_KEY"
                          },
                          success: function(response) {
                              var location = response.results[0].geometry.location;
                              var lat = location.lat;
                              var lng = location.lng;

                              console.log("Latitude: " + lat + ", Longitude: " + lng);
                          }
                      });*/

                $("#pickupMapModal").modal('show');
                let map = new google.maps.Map(document.getElementById('pickup_maps'), {
                    center: {lat: lat, lng: lng},
                    zoom: 13
                });

                // Initialize the Google Places Autocomplete API
                var input = document.getElementById('search');

                var options_pickup = {
                    types: ['address'],
                    componentRestrictions: {country: pickup_country}
                };
                var options_desti = {
                    types: ['address'],
                    componentRestrictions: {country: destination_country}
                };

                if (input_type == 'sender') {
                    var autocomplete = new google.maps.places.Autocomplete(input, options_pickup);
                } else {
                    var autocomplete = new google.maps.places.Autocomplete(input, {
                        types: ['address'],

                    });
                }
                setTimeout(function () {
                    $("#search").val(value).trigger('click').focus();

                }, 1000)


                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var near_place = autocomplete.getPlace();

                    var address = near_place.formatted_address;


                    if (input_type == 'sender') {

                        $("#sender_city").val(address).blur();

                    } else {
                        $("#receiver_city").val(address).blur();
                    }

                    if (!near_place.geometry) {

                        return;
                    }

                    map.fitBounds(near_place.geometry.viewport);
                    marker.setPosition(near_place.geometry.location);
                    marker.setVisible(true);

                });

                // Bind the map's bounds (viewport) property to the autocomplete object
                autocomplete.bindTo('bounds', map);

                // Create a marker to represent the selected place
                marker = new google.maps.Marker({
                    map: map,
                    position: {lat: lat, lng: lng},
                    draggable: true
                });


                google.maps.event.addListener(marker, 'dragend', function (evt) {
                    var lat = evt.latLng.lat().toFixed(3);
                    var lng = evt.latLng.lng().toFixed(3);

                    var latlng = new google.maps.LatLng(lat, lng);
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': latlng}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {


                                if (input_type == 'sender') {

                                    $("#sender_city").val(results[1].formatted_address);
                                    esti_calc();

                                } else {

                                    $("#receiver_city").val(results[1].formatted_address);
                                    esti_calc('receiver');
                                }
                            }
                        }
                    })


                })
            } catch (except) {
                console.log('exception')
            }
            // Listen for user input and update the map and marker

        }

        /*  function geoMap() {
              // Geocode the postal code to get t{he latitude and longitude
              var geocoder = new google.maps.Geocoder();
              geocoder.geocode({"address": postalCode}, function (results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                      // Get the latitude and longitude of the postal code
                      var lat = results[0].geometry.location.lat();
                      var lng = results[0].geometry.location.lng();


                      // Create a new map and add a marker at the location
                      var map = new google.maps.Map(document.getElementById("pickup_maps"), {
                          zoom: 8,
                          center: new google.maps.LatLng(lat, lng)
                      });
                      var marker = new google.maps.Marker({
                          position: new google.maps.LatLng(lat, lng),
                          map: map,
                          draggable:true
                      });
                      marker.setMap(map);
                      //open the marker
                      marker.addListener('click', function () {
                          infowindow.open(map, marker);
                      });


                      var input = document.getElementById("search");



                      var autocomplete = new google.maps.places.Autocomplete(input);
                      console.log(autocomplete)

                      autocomplete.addListener('place_changed', function () {

                          var place = autocomplete.getPlace();

                          // place variable will have all the information you are looking for.


                      });

                          } else {
                      alert("Geocoding failed: " + status);
                  }

              });
          }*/

        $(function () {
            let which_input;
            $('.map-icon-wrapper').click(function () {
                var val = $(this).parent().find("input").val();
                which_input = $(this).parent().find("input").attr('name') == 'sender_city' ? 'sender' : 'receiver';

                geoMaps(val, which_input)

            });
            $('#pickupMapModal').on('hide.bs.modal', function (e) {
                try {
                    // Get the current position of the marker
                    var markerPosition = marker.getPosition();
                    var lats = markerPosition.lat()
                    var longs = markerPosition.lng()
                    var latlng = new google.maps.LatLng(lats, longs);
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': latlng}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {


                                if (which_input == 'sender') {

                                    $("#sender_city").val(results[1].formatted_address);

                                    esti_calc();

                                } else {

                                    $("#receiver_city").val(results[1].formatted_address);
                                    esti_calc('receiver');
                                }
                            }
                        }
                    })
                } catch (except) {
                    console.log('eureka')
                }
            });


            @if(session()->has('price_page') && isset(session('price_page')['receiver_city']) && session('price_page')['receiver_city'] != "")


            function recieveChange() {


                $("#receiver_city").blur();


                if ($("#price_val").text() !== "") {

                    clearInterval(interval);

                }


            }

            var interval = setInterval(recieveChange, 2000)


            @endif

        });





        $("#submitbtn").click(function (e) {
            e.preventDefault();

            $("#submitbtn").attr('disabled','disabled');

            let sender_dialcode = $(".sender-phone-input").find('.iti__selected-dial-code').text();
            let receiver_dialcode = $(".receiver-phone-input").find('.iti__selected-dial-code').text();
            let contact_dialcode = $(".contact-phone-input").find('.iti__selected-dial-code').text();

            let sender_full_phone1 = sender_dialcode +  $('#sender_phone').val();
            let receiver_full_phone1= receiver_dialcode +  $('#receiver_phone').val();
            let contact_full_phone1 = contact_dialcode +  $('#contact_phone').val();

            $("input[name='sender_full_phone']").val(sender_full_phone1);
            $("input[name='receiver_full_phone']").val(receiver_full_phone1);
            $("input[name='contact_full_phone']").val(contact_full_phone1);


            var _token = $("input[name='_token']").val();
            // var who_type = $('input[name="who_type"]:checked').val();
            var pickup_country = $('#pickup_country').val();
            var sender_city = $('#sender_city').val();
            var sender = $('#sender').val();
            var sender_phone = sender_full_phone1;//$('#sender_phone').val();
            var sender_full_phone = sender_full_phone1; //$("input[name='sender_full_phone']").val();
            var desti_country = $('#desti_country').val();
            var receiver_city = $('#receiver_city').val();
            var receiver = $('#receiver').val();
            var receiver_phone = receiver_full_phone1;//$('#receiver_phone').val();
            var receiver_full_phone = receiver_full_phone1;//$("input[name='receiver_full_phone']").val();
            var van_type = $('input[name="van_type"]:checked').val();
            var help_loading = $("#help_loading_card").attr("aria-checked");
            var help_unloading = $("#help_unloading_card").attr("aria-checked");
            var tail_lift = $("#help_lift_card").attr("aria-checked");
            var cargo_info = $('#cargo_info').val();
            var cargo_val = $('#cargo_val').val();
            var collection_day = $('#datepicker').val();
            var contact_name = $('#contact_name').val();
            var contact_email = $('#contact_email').val();
            var user_email = $('#user_email').val();
            var user_vat = $('#user_vat').val();
            var contact_phone = contact_full_phone1;//$('#contact_phone').val();
            var contact_full_phone = contact_full_phone1; //$("input[name='contact_full_phone']").val();
            var contact_note = $('#contact_note').val();
            var term_agree = $('input[name="term_agree"]:checked').val();
            var price = $('#price_val').html();

            /*    if (who_type == '') {
                    $('#who_type_invalid').show();
                    $("#who_type").focus();
                } else {
                    $('#who_type_invalid').hide();
                }*/
            if (pickup_country == '') {
                $('#pickup_country_invalid').show();
                $("#pickup_country").focus();
            } else {
                $('#pickup_country_invalid').hide();
            }
            if (sender_city == '') {
                $('#sender_city_invalid').show();
                $("#sender_city").focus();
            } else {
                $('#sender_city_invalid').hide();
            }
            if (sender == '') {
                $('#sender_invalid').show();
                $("#sender").focus();
            } else {
                $('#sender_invalid').hide();
            }
            if (sender_phone == '') {
                $('#sender_phone_invalid').show();
                $("#sender_phone").focus();
            } else {
                $('#sender_phone_invalid').hide();
            }
            if (desti_country == '') {
                $('#desti_country_invalid').show();
                $("#desti_country").focus();
            } else {
                $('#desti_country_invalid').hide();
            }
            if (receiver_city == '') {
                $('#receiver_city_invalid').show();
                $("#receiver_city").focus();
            } else {
                $('#receiver_city_invalid').hide();
            }
            if (receiver == '') {
                $('#receiver_invalid').show();
                $("#receiver").focus();
            } else {
                $('#receiver_invalid').hide();
            }
            if (receiver_phone == '') {
                $('#receiver_phone_invalid').show();
                $("#receiver_phone").focus();
            } else {
                $('#receiver_phone_invalid').hide();
            }
            if (cargo_info == '') {
                $('#cargo_info_invalid').show();
                $("#cargo_info").focus();
            } else {
                $('#cargo_info_invalid').hide();
            }
            if (cargo_val == '') {
                $('#cargo_val_invalid').show();
                $("#cargo_val").focus();
            } else {
                $('#cargo_val_invalid').hide();
            }
            if (collection_day == '') {
                $('#collection_day_invalid').show();
                $("#collection_day").focus();
            } else {
                $('#collection_day_invalid').hide();
            }
            if (contact_name == '') {
                $('#contact_name_invalid').show();
                $("#contact_name").focus();
            } else {
                $('#contact_name_invalid').hide();
            }
            if (contact_email == '') {
                $('#contact_email_invalid').show();
                $("#contact_email").focus();
            } else {
                $('#contact_email_invalid').hide();
            }
            if (contact_phone == '') {
                $('#contact_phone_invalid').show();
                $("#contact_phone").focus();
            } else {
                $('#contact_phone_invalid').hide();
            }
            if (term_agree == '') {
                $('#term_agree_invalid').show();
                $("#term_agree").focus();
            } else {
                $('#term_agree_invalid').hide();
            }

            // who_type == '' ||
            if (pickup_country == '' || sender_city == '' || sender == '' ||
                sender_phone == '' || desti_country == '' || receiver_city == '' || receiver == '' ||
                receiver_phone == '' || cargo_info == '' || cargo_val == '' || collection_day == '' || contact_name == '' ||
                contact_email == '' || contact_phone == '' || term_agree == '') {
                    $("#submitbtn").removeAttr('disabled','disabled');
                return;
            }

            if (price == '') {
                $("#submitbtn").removeAttr('disabled','disabled');
                Command: toastr["warning"]("Please check a price!", "Warning");
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('price.create') }}",
                data: {
                    _token: _token,
                    // who_type: who_type,
                    pickup_country: pickup_country,
                    sender_city: sender_city,
                    sender: sender,
                    id : "{{$id}}",
                    sender_phone: sender_phone,
                    sender_full_phone: sender_full_phone,
                    desti_country: desti_country,
                    receiver_city: receiver_city,
                    receiver: receiver,
                    receiver_phone: receiver_phone,
                    receiver_full_phone: receiver_full_phone,
                    van_type: van_type,
                    help_loading: help_loading,
                    help_unloading: help_unloading,
                    tail_lift: tail_lift,
                    cargo_info: cargo_info,
                    distance_is:$("#distance_val").text() ,
                    duration_is: $("#duration_val").text(),
                    cargo_val: cargo_val,
                    collection_day: collection_day,
                    contact_name: contact_name,
                    contact_email: contact_email,
                    user_email: user_email,
                    user_vat: user_vat,
                    contact_phone: contact_phone,
                    contact_full_phone: contact_full_phone,
                    contact_note: contact_note,
                    term_agree: term_agree,
                    price: price,
                },
                success: function (data) {
                    $("#submitbtn").removeAttr('disabled','disabled');
                    if (data.status == '5') {
                        Command: toastr["warning"]("You do not have permission to access for this page.", "Warning");
                        return false;
                    } else if (data.status == '2') {
                        Command: toastr["success"]("Valid Request", "Success");
                        if(data.id > 0){
                            $("#CurrentOrderId").val(data.id);
                            $("#CurrentOrderNo").val(data.order_number);
                            $("#CurrentPrice").val(data.amount);
                            $("#CurrentOrderUrlId").val(data.url_id);

                            $("#current_email").val(contact_email);
                            $("#current_order_number").val(data.order_number);
                            $("#CurrentOrderPrice").val(data.amount);

                            $("#createBtnBlock").css('display','none');
                            $("#paymentBlock").css('display','');

                            let amount = Math.round(parseFloat(data.amount) * 100);

                          /*  $("#curPaymentLink").attr("data-amount", amount);
                            $('.checkoutView').find('.stripe-button').attr('data-amount', amount);
                            $('.checkoutView').find('.stripe-button').attr('amount', amount);
                            let curPaymentText = "Pay €" + data.amount;
                            $('.checkoutView').find('.iconTick').text(curPaymentText);*/

                            let formHtml = '<input type="hidden" value= "' + amount + '" name="price" id="CurrentOrderPrice">';
                            formHtml += '<input type="hidden" value= "' + amount +'" name="amount">';
                            formHtml +=  '<input type="hidden" value="' + data.order_number +'" name="order_number" id="current_order_number">';
                            formHtml += '<input type="hidden" value="' + contact_email + '" name="email" id="current_email">';
                            formHtml += '<script id="curPaymentLink" src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{config('stripe.stripe_key_live')}}" data-amount="' + amount + '" data-name="Easy Move Europe" data-description="Payment" data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto" data-zip-code="false" data-currency="eur"><\/script>';


                            $("#checkout_page").html(formHtml);

                        }
                        return false;
                    } else if (data.status == '1') {
                        Command: toastr["error"]("{{__("Database Error")}}", "Error");
                        return false;
                    } else if (data.status == '0') {
                        printErrorMsg(data.error);
                        return false;
                    }
                },
                error: function (data) {
                    $("#submitbtn").removeAttr('disabled','disabled');
                    if (data.status == '401') {
                        Command: toastr["warning"]("{{__("Please login firstly!")}}", "Warning");
                        setTimeout(() => {
                            window.location.href = "/login";
                        }, "3000")
                        return false;
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

            function printErrorMsg(msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(msg, function (key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    $(".print-error-msg").focus();
                });
            }
        });

</script>

        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    ///************* Payment functions *************** */

        var $form = $(".validation");
            $('form.validation').bind('submit', function(e) {
                var $form = $(".validation"),
                    inputVal = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputVal),
                    $errorStatus = $form.find('div.error'),
                    valid = true;
                $errorStatus.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorStatus.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-num').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeHandleResponse);
                }

            });

            function stripeHandleResponse(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }



        $("#btnBank").click(function(){
            $("#btnBank").attr('disabled','disabled');
                let order_no = $("#CurrentOrderNo").val();
                let order_id = $("#CurrentOrderId").val();
                let cur_ordernox = $("#CurrentOrderUrlId").val();

                window.location.href = '{{url('bank_payment')}}' + '/' + cur_ordernox;
        });

        $("#btnDeferred").click(function(){
            $("#btnDeferred").attr('disabled','disabled');
            let order_no = $("#CurrentOrderNo").val();
            let order_id = $("#CurrentOrderId").val();
            let cur_ordernox = $("#CurrentOrderUrlId").val();

            window.location.href = '{{url('defferd_payment')}}' + '/' + cur_ordernox;

        });

        $("#btnOnline").click(function(){
            $("#btnOnline").attr('disabled','disabled');

                let order_no = $("#CurrentOrderNo").val();
                let order_id = $("#CurrentOrderId").val();
                let cur_ordernox = $("#CurrentOrderUrlId").val();

                setTimeout(() => {
                                $("#checkout_page").find('button').click();
                        }, "2000")
                        $("#btnOnline").removeAttr('disabled','disabled');
        });

 $('#pickup_country:eq(1)').hide();
            $('#desti_country:eq(1)').hide();

        const stripe = Stripe("{{env('STRIPE_KEY')}}");
    </script>

    <form action="{{route('stripe.payment')}}" id="checkout_page" method="post" style="display:none">
        <input type="hidden" value= "" name="price" id="CurrentOrderPrice">
        <input type="hidden" value= "" name="amount">
        <input type="hidden" value="" name="order_number" id="current_order_number">
        <input type="hidden" value="" name="email" id="current_email">

        <script id="curPaymentLink" src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{config('stripe.stripe_key_live')}}"
                                data-amount=100.00
                                data-name="Easy Move Europe"
                                data-description="Payment"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto"
                                data-zip-code="false"
                                data-currency="eur"></script>

    </form>




@endsection
