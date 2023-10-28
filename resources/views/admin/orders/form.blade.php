@extends('layouts.adminApp')
@section('style')
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
        .get-a-quote .quote-bg {
            min-height: 500px;
            background-size: cover;
            background-position: center;
        }

        .get-a-quote .php-email-form {
            background: #f3f6fc;
            padding: 40px;
            height: 100%;
        }

        @media (max-width: 575px) {
            .get-a-quote .php-email-form {
                padding: 20px;
            }
        }

        .get-a-quote .php-email-form h3 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .get-a-quote .php-email-form h4 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0 0 0;
        }

        .get-a-quote .php-email-form p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .get-a-quote .php-email-form .error-message {
            display: none;
            color: #fff;
            background: #df1529;
            text-align: left;
            padding: 15px;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .get-a-quote .php-email-form .sent-message {
            display: none;
            color: #fff;
            background: #059652;
            text-align: center;
            padding: 15px;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .get-a-quote .php-email-form .loading {
            display: none;
            background: #fff;
            text-align: center;
            padding: 15px;
            margin-bottom: 24px;
        }

        .get-a-quote .php-email-form .loading:before {
            content: "";
            display: inline-block;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            margin: 0 10px -6px 0;
            border: 3px solid #059652;
            border-top-color: #fff;
            -webkit-animation: animate-loading 1s linear infinite;
            animation: animate-loading 1s linear infinite;
        }

        .get-a-quote .php-email-form input,
        .get-a-quote .php-email-form textarea {
            box-shadow: none;
            font-size: 14px;
        }

        .get-a-quote .php-email-form input:focus,
        .get-a-quote .php-email-form textarea:focus {
            border-color: grey;
        }

        .get-a-quote .php-email-form textarea {
            padding: 12px 15px;
        }

        .get-a-quote .php-email-form button {
            background: rgb(54 82 126);
            border: 0;
            padding: 10px 30px;
            color: #fff;
            transition: 0.4s;
            border-radius: 4px;
        }

        .get-a-quote .php-email-form button:hover {
            background: rgb(37 50 72);
        }

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

        .d-none{
            display:none;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

@endsection


@section('content') 
    <section id="get-a-quote" class="get-a-quote">
        <div class="container" data-aos="fade-up">
            <div class="row g-0">

                <form method="post" class="php-email-form" style="width:100%">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id" value="{{$reqItem->id}}" />
                    <input type="hidden" name="user_id" id="user_id" value="{{$reqItem->user_id}}" />
                    
                    <div class="row mt-5 personal-section">
                        <div class="row col-12 col-md-12 personal-infos mb-3">
                            <div class="col-md-6">
                            <table class="table table-striped">
                            <tr>
                                <td style="background-color:#352b53; color:#fff; padding:7px;"><strong>Order number: &nbsp;&nbsp;</strong>{{$reqItem->order_number}}</td>
                            </tr>
                            <tr>
                                <td style="padding:0;">
                                    <table style="width:100%; ">
                                        <tr>
                                            <td style="padding:5px;">Route:</td>
                                            <td style="width:40%;padding:5px; text-align:right;">{{$reqItem->pickup_country}} - {{$reqItem->desti_country}}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px;">Created at:</td>
                                            <td style="width:40%;padding:5px; text-align:right;">{{ date_format($reqItem->created_at, "d.m.Y")}}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px;">Payment date:</td>
                                            <?php
                                            if($cur_invoice != ""){
                                                if($cur_invoice->status == 'Paid' && $cur_invoice->paid_date != "" && $cur_invoice->paid_date !=null)
                                                {
                                            ?>
                                            <td style="width:40%;padding:5px; text-align:right;">{{ date("d.m.Y", strtotime($cur_invoice->paid_date))}}</td>
                                            <?php
                                                }
                                                else{

                                            ?>
                                                <td style="width:40%;padding:5px; text-align:right;"></td>
                                            <?php
                                                }
                                            }
                                            else{
                                                ?>
                                                    <td style="width:40%;padding:5px; text-align:right;"></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px;">Pickup date:</td>
                                            <td style="width:40%;padding:5px; text-align:right;">
                                            <input name="collection_day" class="form-control" value="{{ date('d/m/Y', strtotime($reqItem->collection_day)) }}" id="datepicker" />
                                            
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px;">Payment method:</td>
                                            <td style="width:40%;padding:5px; text-align:right;">
                                                <select name="lstPymentMethod" id="lstPymentMethod">
                                                    <option value="Credit Card">Credit Card</option>
                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                    <option value="Deferred">Deferred</option>                                                    
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px;">Price offerd by carrier:</td>
                                            <td style="width:40%;padding:5px; text-align:right;">
                                                <input type="text" name="txtCarrierOfferd" id="txtCarrierOfferd" value="{{$reqItem->carrier_price}}" min="0" style="text-align:right;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <?php
                                                $duration = $reqItem->duration;
                                               // preg_match_all('!\d+!', $duration, $matches);
                                                $matches = preg_replace('/[^0-9]/', '', $duration);
                                            ?>
                                            <td style="padding:5px;">EDT (hours):</td>
                                            <td style="width:40%;padding:5px; text-align:right;">{{$matches}}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px;">Sale price:</td>
                                            <td style="width:40%;padding:5px; text-align:right;" class="OrderTotX1">
                                                @if($cur_order_status == 'Waiting Payment')
                                                <input type="text" name="txtTotalPrice" id="txtTotalPrice" value="{{number_format($reqItem->price,2,'.','')}}"  min="0" style="text-align:right;" />
                                                @else
                                                <input type="text" name="txtTotalPrice" id="txtTotalPrice" value="{{number_format($reqItem->price,2,'.','')}}"  min="0" style="text-align:right;" readonly />
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                             <?php
                                                $distance = $reqItem->distance;
                                               // preg_match_all('!\d+!', $distance, $matches1);
                                               $matches1 = preg_replace('/[^0-9]/', '', $distance);
                                            ?>
                                            <td style="padding:5px;">Distance (km):</td>
                                            <td style="width:40%;padding:5px; text-align:right;">{{$matches1}}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px;">Cargo information:</td>
                                            <td style="width:40%;padding:5px; text-align:right;">{{$reqItem->cargo_info}}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px;">Cargo Value:</td>
                                            <td style="width:40%;padding:5px; text-align:right;">{{number_format($reqItem->cargo_val,2)}}</td>
                                        </tr>
                                        <tr>
                                            <?php
                                                $str_user_id = "";
                                            if($reqItem->who_type != "Guess"){
                                                $str_user_id = $reqItem->user_id;

                                                if($str_user_id < 10)
                                                {
                                                    $str_user_id = "00000" . $str_user_id;
                                                }

                                                if($str_user_id >= 10 && $str_user_id < 100)
                                                {
                                                    $str_user_id = "0000" . $str_user_id;
                                                }

                                                if($str_user_id >= 100 && $str_user_id < 1000)
                                                {
                                                    $str_user_id = "000" . $str_user_id;
                                                }

                                                if($str_user_id >= 1000 && $str_user_id < 10000)
                                                {
                                                    $str_user_id = "00" . $str_user_id;
                                                }

                                                if($str_user_id >= 10000 && $str_user_id < 100000)
                                                {
                                                    $str_user_id = "0" . $str_user_id;
                                                }
                                            }
                                            ?>
                                            <td colspan="2" style="padding:5px;  background-color:#c3c3c3;"><span style="width:40%; text-align:left; display:inline-block;">User code:</span><span style="width:40%; text-align:center; display:inline-block;">Client code: {{$str_user_id}} </span><span style="width:20%; display:inline-block; text-align:right;">{{$reqItem->who_type}}</span></td>
                                        </tr>
                                        <tr>
                                            <?php
                                                $vatx = 19;
                                                if($reqItem->who_type == "Company"){
                                                    $vatx = 0;
                                                }
                                            ?>
                                            <td colspan="2" style="padding:5px;"><span style="width:60%; text-align:left; display:inline-block;"></span><span style="width:25%; text-align:left; display:inline-block;">VAT Status:</span><span style="width:15%; text-align:center; display:inline-block;">{{$vatx}}%</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding:5px;">
                                                <span style="width:30%; text-align:left; display:inline-block;">Invoices:</span>
                                                <span style="width:22%; text-align:left; display:inline-block;">
                                                    <input type="checkbox" id="invoiceType1" name="chInvoiceType" class="invoiceTypeX" value="Per Order" disabled />
                                                    <label for="invoiceType1" style="width:80%; float:right; padding-top:3px;">Per Order</label>
                                                </span>
                                                <span style="width:22%; text-align:left; display:inline-block;">
                                                    <input type="checkbox" id="invoiceType2" name="chInvoiceType" class="invoiceTypeX" value="Per Week" disabled />
                                                    <label for="invoiceType2" style="width:80%; float:right; padding-top:3px;">Per Week</label>
                                                </span>
                                                <span style="width:22%; text-align:left; display:inline-block;">
                                                    <input type="checkbox" id="invoiceType3" name="chInvoiceType" class="invoiceTypeX" value="Per Month" disabled />
                                                    <label for="invoiceType3" style="width:80%; float:right; padding-top:3px;">Per Month</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding:5px;">
                                            <span style="width:30%; text-align:left; display:inline-block;">Order Status:</span>
                                            <span style="width:69%; text-align:left; display:inline-block;">
                                                <select id="orderStatus" name="orderStatus">
                                                    <option value="Waiting Payment">Waiting Payment</option>
                                                    <option value="Deferred Payment">Deferred Payment</option>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Confirmed">Confirmed</option>
                                                    <option value="Cancelled After Payment">Cancelled After Payment</option>
                                                    <option value="Cancelled Before Payment">Cancelled Before Payment</option>
                                                </select>
                                            </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding:5px;">
                                            <span style="width:30%; text-align:left; display:inline-block;">Carrier:</span>
                                            <span style="width:69%; text-align:left; display:inline-block;">
                                                <select id="carrier" name="carrier">
                                                    <option value=""> - Select - </option>
                                                    @foreach($carrier as $item)
                                                        <option value="{{$item->id}}">{{$item->carrier_name}}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:0; background-color:#ffffff;">
                                <div style="width:100%;background-color:#ffffff;padding:25px 5px 5px 5px;">
                                    <span style="width:30%; text-align:left; display:inline-block;background-color:#fff;">
                                        <input type="button" name="btnSave1" id="btnSave1" value="Save & Update" />
                                    </span>
                                    <span style="width:60%; text-align:left; display:inline-block;background-color:#fff;">
                                        <input type="button" name="btnSend1" id="btnSend1" value="Send the order to Carrier" />
                                    </span>  
                                </div>          
                                </td>
                             </tr>
                             <tr>
                                <td colspan="2" style="padding:0;">
                                <div style="width:100%;padding:5px; border:1px solid #000; margin-bottom:10px;">
                                    <span style="width:100%; text-align:left; display:inline-block; font-weight:600; margin-top:10px; margin-bottom:20px;">Pick-up information:</span>
                                    <div id="pickupBlock1">
                                    <span style="width:100%; text-align:left; display:inline-block;">
                                        <input type="text" name="pickupName" id="pickupName" class="form-control" value="{{$reqItem->sender}}" disabled />
                                    </span>
                                    <span style="width:100%; text-align:left; display:inline-block;">
                                        <input type="text" name="pickupAddress" id="pickupAddress" class="form-control" value="{{$reqItem->sender_city}}" disabled />
                                    </span>
                                    <span style="width:100%; text-align:left; display:inline-block; margin-bottom:20px;">
                                        <input type="text" name="pickupPhone" id="pickupPhone" class="form-control" value="{{$reqItem->sender_full_phone}}" disabled />
                                    </span>
                                    </div>
                                             

                                    <span style="width:30%; text-align:left; display:inline-block;">
                                        <input type="button" name="btnEdit1" id="btnEdit1" value="Edit" style="width:80px;" />
                                    </span>
                                    <span style="width:60%; text-align:left; display:inline-block;">
                                        <input type="button" name="btnCollection1" id="btnCollection1" value="Add new collection address" />
                                    </span>
                                    @if(count($pickup_address) > 0)
                                    <div style="width:100%; margin-top:10px;">
                                    <?php $addressx1 = 2;?>
                                        @foreach($pickup_address as $pickups)
                                        <span style="width:100%; text-align:left; display:inline-block; font-weight:600; margin-top:5px; font-size:14px; margin-bottom:5px;">{{$addressx1}}. <span style="float:right;"> <input type="button" id="btnorderExEdit_{{$pickups->id}}" class="btnOrderAddressEdit" data-id="{{$pickups->id}}" value="Edit" style="margin-right:10px;" />&nbsp;<input type="button" id="btnorderExEdit_{{$pickups->id}}" class="btnOrderAddressDelete" data-id="{{$pickups->id}}" value="Delete" /></span> </span>
                                        <span style="width:100%; text-align:left; font-size:12px; display:inline-block; border-top:1px solid #ccc;"><input type="text" name="orderExName_{{$pickups->id}}" id="orderExName_{{$pickups->id}}" value="{{$pickups->contact_name}}" style="width:100%;" disabled /></span>
                                        <span style="width:100%; text-align:left; font-size:12px; display:inline-block;"><input type="text" name="orderExAddress_{{$pickups->id}}" id="orderExAddress_{{$pickups->id}}" value="{{$pickups->contact_address}}" style="width:100%;" disabled /></span> 
                                        <span style="width:100%; text-align:left; font-size:12px; display:inline-block;"><input type="text" name="orderExTel_{{$pickups->id}}" id="orderExTel_{{$pickups->id}}" value="{{$pickups->contact_phone}}" style="width:100%;" disabled /></span>    
                                        <?php $addressx1++;?>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>          
                                </td>
                             </tr>

                             <tr>
                                <td colspan="2" style="padding:0;">
                                <div style="width:100%;padding:5px; border:1px solid #000;">
                                    <span style="width:100%; text-align:left; display:inline-block; font-weight:600; margin-top:10px; margin-bottom:20px;">Delivery information:</span>
                                    <div id="deliveryBlock1">
                                    <span style="width:100%; text-align:left; display:inline-block;">
                                        <input type="text" name="receiverName" id="receiverName" class="form-control" value="{{$reqItem->receiver}}" disabled />
                                    </span>
                                    <span style="width:100%; text-align:left; display:inline-block;">
                                        <input type="text" name="receiverAddress" id="receiverAddress" class="form-control" value="{{$reqItem->receiver_city}}" disabled />
                                    </span>
                                    <span style="width:100%; text-align:left; display:inline-block; margin-bottom:20px;">
                                        <input type="text" name="receiverPhone" id="receiverPhone" class="form-control" value="{{$reqItem->receiver_full_phone}}" disabled />
                                    </span>
                                    </div>
                                         

                                    <span style="width:30%; text-align:left; display:inline-block;">
                                        <input type="button" name="btnEdit2" id="btnEdit2" value="Edit" style="width:80px;" />
                                    </span>
                                    <span style="width:60%; text-align:left; display:inline-block;">
                                        <input type="button" name="btnCollection2" id="btnCollection2" value="Add new delivery address" />
                                    </span>  

                                    @if(count($delivery_address) > 0)            
                                    <div style="width:100%; margin-top:10px;">
                                    <?php $addressx2 = 2;?>
                                        @foreach($delivery_address as $delivery)
                                        <span style="width:100%; text-align:left; display:inline-block; font-weight:600; margin-top:5px; font-size:14px; margin-bottom:5px;">{{$addressx2}}. <span style="float:right;"> <input type="button" id="btnorderExEdit_{{$delivery->id}}" class="btnOrderAddressEdit" data-id="{{$delivery->id}}" value="Edit" style="margin-right:10px;" />&nbsp;<input type="button" id="btnorderExEdit_{{$delivery->id}}" class="btnOrderAddressDelete" data-id="{{$delivery->id}}" value="Delete" /></span></span>
                                        <span style="width:100%; text-align:left; font-size:12px; display:inline-block; border-top:1px solid #ccc;"><input type="text" name="orderExName_{{$delivery->id}}" id="orderExName_{{$delivery->id}}" value="{{$delivery->contact_name}}" style="width:100%;" disabled /></span>
                                        <span style="width:100%; text-align:left; font-size:12px; display:inline-block;"><input type="text" name="orderExAddress_{{$delivery->id}}" id="orderExAddress_{{$delivery->id}}" value="{{$delivery->contact_address}}" style="width:100%;" disabled /></span> 
                                        <span style="width:100%; text-align:left; font-size:12px; display:inline-block;"><input type="text" name="orderExTel_{{$delivery->id}}" id="orderExTel_{{$delivery->id}}" value="{{$delivery->contact_phone}}" style="width:100%;" disabled /></span>
                                        <?php $addressx2++;?>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>          
                                </td>
                             </tr>

                             <tr>
                                <td colspan="2" style="padding:0;">
                                <div style="width:100%;padding:5px; border:1px solid #000; margin-top:10px;">
                                    <span style="width:100%; text-align:left; display:inline-block; font-weight:600; margin-top:10px; margin-bottom:20px;">Customer's comment:</span>
                               
                                    <span style="width:100%; text-align:left; display:inline-block; margin-bottom:15px;">
                                        <textarea name="customer_note" id="customer_note" class="form-control" disabled>{{$reqItem->contact_note }}</textarea>
                                    </span>
                                                                    
     
                                    <span style="width:30%; text-align:left; display:inline-block;">
                                        <input type="button" name="btnEdit3" id="btnEdit3" value="Edit" style="width:80px;" />
                                    </span>
                                    <span style="width:60%; text-align:left; display:inline-block;">
                                    </span>  
                                </div>          
                                </td>
                             </tr>

                            </table>


                            </div>

                            <!--Right Column -->
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td style="padding-top:10px;">
                                            <table style="width:100%">
                                                <tr>
                                                    <td style="background-color:#352b53; color:#fff; padding:2px;">Order number</td>
                                                    <td style="background-color:#352b53; color:#fff; padding:2px; text-align:center;">Type</td>       
                                                    <td style="background-color:#352b53; color:#fff; padding:2px;">Price</td>
                                                    <td style="background-color:#352b53; color:#fff; padding:2px;">Status</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:2px; font-weight:600;">{{$reqItem->order_number}}</td>
                                                    <td style="padding:2px;">
                                                        <select id="carrierType" name="carrierType">
                                                            @if($reqItem->van_type == "box")
                                                            <option value="box">Box Van</option>
                                                            <option value="Curtain Sider">Curtain Sider</option>
                                                            @else
                                                            <option value="Curtain Sider">Curtain Sider</option>
                                                            <option value="box">Box Van</option>                                                            
                                                            @endif
                                                        </select>
                                                    </td>       
                                                    <td style="padding:2px;" class="OrderTotX">{{number_format($reqItem->price,2)}}</td>
                                                    <td style="padding:2px;">{{ucwords(strtolower($reqItem->status))}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:0;">
                                                        <table style="width:100%;">
                                                            <tr>
                                                                <td style="width:60%; padding:0 5px;">
                                                                    <input type="checkbox" id="exCharge1" name="exCharge" class="exChargeX" value="true" data-id="0" data-val="{{$vatx==0?$additional[0]['zero-vat']:$additional[0]['fee-vat']}}" style="width:16px; height:16px; margin-bottom:3px;" />
                                                                    <label for="exCharge1" style="width:80%; padding-top:0px; color:#000;">Help to load</label>
                                                                </td>
                                                                <td style="padding:0 5px;">
                                                                    <input type="text" name="txtExPrice1" id="txtExPrice1" value="{{$vatx==0?$additional[0]['zero-vat']:$additional[0]['fee-vat']}}" style="text-align:right" readonly />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:60%; padding:0 5px;">
                                                                    <input type="checkbox" id="exCharge2" name="exCharge" class="exChargeX" value="true" data-id="1" data-val="{{$vatx==0?$additional[1]['zero-vat']:$additional[1]['fee-vat']}}" style="width:16px; height:16px; margin-bottom:3px;" />
                                                                    <label for="exCharge2" style="width:80%; padding-top:0px; color:#000;">Help to unload</label>
                                                                </td>
                                                                <td style="padding:0 5px;">
                                                                    <input type="text" name="txtExPrice2" id="txtExPrice2" value="{{$vatx==0?$additional[1]['zero-vat']:$additional[1]['fee-vat']}}" style="text-align:right" readonly />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:60%; padding:0 5px;">
                                                                    <input type="checkbox" id="exCharge3" name="exCharge" class="exChargeX" value="true" data-id="2" data-val="{{$vatx==0?$additional[2]['zero-vat']:$additional[2]['fee-vat']}}" style="width:16px; height:16px; margin-bottom:3px;" />
                                                                    <label for="exCharge3" style="width:80%; padding-top:0px; color:#000;">tail lift</label>
                                                                </td>
                                                                <td style="padding:0 5px;">
                                                                    <input type="text" name="txtExPrice3" id="txtExPrice3" value="{{$vatx==0?$additional[2]['zero-vat']:$additional[2]['fee-vat']}}" style="text-align:right" readonly />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:60%; padding:0 5px;">
                                                                    <input type="checkbox" id="exCharge4" name="exCharge" class="exChargeX" value="true" data-id="3" data-val="{{$vatx==0?$additional[3]['zero-vat']:$additional[3]['fee-vat']}}"  style="width:16px; height:16px; margin-bottom:3px;" />
                                                                    <label for="exCharge4" style="width:80%; padding-top:0px; color:#000;">Pickup on the Weekend</label>
                                                                </td>
                                                                <td style="padding:0 5px;">
                                                                    <input type="text" name="txtExPrice4" id="txtExPrice4" value="{{$vatx==0?$additional[3]['zero-vat']:$additional[3]['fee-vat']}}" style="text-align:right" readonly />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:60%; padding:0 5px;">
                                                                   
                                                                    <input type="checkbox" id="exCharge5" name="exCharge" class="exChargeX" value="true" data-id="4" data-val="{{$vatx==0?$additional[4]['zero-vat']:$additional[4]['fee-vat']}}" style="width:16px; height:16px; margin-bottom:3px;" />
                                                                    <label for="exCharge5" style="width:80%; padding-top:0px; color:#000;">Pickup Same-day</label>
                                                                </td>
                                                                <td style="padding:0 5px;">
                                                                    <input type="text" name="txtExPrice5" id="txtExPrice5" value="{{$vatx==0?$additional[4]['zero-vat']:$additional[4]['fee-vat']}}" style="text-align:right" readonly />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:60%; padding:0 5px;">
                                                                    <input type="checkbox" id="exCharge6" name="exCharge" class="exChargeX" value="true" data-id="5" data-val="{{$vatx==0?$additional[5]['zero-vat']:$additional[5]['fee-vat']}}" style="width:16px; height:16px; margin-bottom:3px;" />
                                                                    <label for="exCharge6" style="width:90%; padding-top:0px; color:#000;">Pickup Country is == Delivery Country</label>
                                                                </td>
                                                                <td style="padding:0 5px;">
                                                                    <input type="text" name="txtExPrice6" id="txtExPrice6"  value="{{$vatx==0?$additional[5]['zero-vat']:$additional[5]['fee-vat']}}" style="text-align:right" readonly />
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td style="width:60%; padding:0 5px;">
                                                                    @if($reqItem->van_type == "box")
                                                                    <input type="checkbox" id="exCharge7" name="exCharge" class="exChargeX" value="true" data-id="6" data-val="{{$vatx==0?'110.00':'130.90'}}" style="width:16px; height:16px; margin-bottom:3px;" />
                                                                    @else
                                                                    <input type="checkbox" id="exCharge7" name="exCharge" class="exChargeX" value="true" data-id="6" data-val="{{$vatx==0?'110.00':'130.90'}}" style="width:16px; height:16px; margin-bottom:3px;" checked />
                                                                    @endif
                                                                    
                                                                    <label for="exCharge7" style="width:90%; padding-top:0px; color:#000;">Curtain side van</label>
                                                                </td>
                                                                <td style="padding:0 5px;">
                                                                    <input type="text" name="txtExPrice7" id="txtExPrice7"  value="{{$vatx==0?'110.00':'130.90'}}" style="text-align:right" readonly />
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td style="width:60%; padding:5px;">
                                                                    <label style="float:right;text-align:right; font-weight:600; color:#000;">Total:</label>
                                                                    <input type="hidden" name="order_total" id="order_total" value="{{$reqItem->price}}" />
                                                                </td>
                                                                <td id="totalBlock1" class="OrderTotX" style="padding:5px; text-align:right; font-weight:600;">
                                                                {{number_format($reqItem->price,2)}}
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding:5px;">
                                                        <span style="width:50%; text-align:left; display:inline-block;">
                                                            <input type="hidden" name="currentExCharges" id="currentExCharges" value="" />
                                                            <input type="hidden" name="removeExCharges" id="removeExCharges" value="" />
                                                            <input type="hidden" name="newExCharges" id="newExCharges" value="" />
                                                            <input type="hidden" name="allExCharges" id="allExCharges" value="" />
                                                            <input type="button" name="btnExtra" id="btnExtra" value="Update extras" />
                                                        </span>  
                                                    </td>
                                                    <td colspan="2" style="padding:5px;">
                                                        <span style="width:100%; text-align:right; display:inline-block;">
                                                            <input type="button" name="btnPaymentLink" id="btnPaymentLink" value="Send Payment Link" />
                                                        </span>  
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:5px;">
                                                        <label style="float:right;font-weight:600; color:#000; width:100%;">Cargo information:</label>
                                                        <textarea type="text" name="txtCargoInfo" id="txtCargoInfo" style="width:100%;" disabled>{{$reqItem->cargo_info}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:5px; border:1px solid #000;">
                                                        <label style="float:right;font-weight:600; color:#000; width:100%;">Additional charges:</label>
                                                        <table style="width:100%;" id="tblAdditionalCharges">
                                                            <tr>
                                                                <th style="width:38%;">Reason</th>
                                                                <th style="width:25%;">Amount (gross)</th>
                                                                <th>Status</th>
                                                                <th style="width:55px;"></th>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:0;">
                                                                    <input type="text" name="txtExtraRequester" id="txtExtraRequester" value="" style="width:95%;" />
                                                                </td>
                                                                <td style="padding:0;">
                                                                    <input type="text" name="txtExtraAmount" id="txtExtraAmount" value="" style="width:95%;" />
                                                                </td>
                                                                <td style="padding:0;">
                                                                    <select id="lstExtraStatus" name="lstExtraStatus"  style="width:95%;">
                                                                        <option value="Waiting Payment">Waiting Payment</option>
                                                                        <option value="Paid">Paid</option>
                                                                    </select>                                                                   
                                                                </td>
                                                                <td style="padding:0;">
                                                                    <input type="button" name="btnAddCharge" id="btnAddCharge" value=" + " title="Add"  style="background-color:#000; color:#fff; font-weight:600;"/>
                                                                </td>
                                                            </tr>
                                                            @foreach($extra as $exitem)
                                                            @if($exitem->charge_type=="Exclude Order")
                                                            <tr>
                                                                <td style="padding:0;">
                                                                    <input type="text" name="txtExtraRequester_{{$exitem->id}}" id="txtExtraRequester_{{$exitem->id}}" value="{{$exitem->requester}}" style="width:95%;" />
                                                                </td>
                                                                <td style="padding:0;">
                                                                    <input type="text" name="txtExtraAmount_{{$exitem->id}}" id="txtExtraAmount_{{$exitem->id}}" value="{{$exitem->amount}}" style="width:95%;" />
                                                                </td>
                                                                @if($exitem->charge_type=="Exclude Order")
                                                                <td style="padding:0;">
                                                                    <select id="lstExtraStatus_{{$exitem->id}}" name="lstExtraStatus_{{$exitem->id}}"  style="width:95%;">
                                                                        @if($exitem->status == "Waiting Payment")
                                                                        <option value="Waiting Payment">Waiting Payment</option>
                                                                        <option value="Paid">Paid</option>
                                                                        @endif
                                                                        @if($exitem->status == "Paid")
                                                                        <option value="Paid">Paid</option>
                                                                        <option value="Waiting Payment">Waiting Payment</option>                                                                        
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                                <td style="padding:0;">
                                                                @if($exitem->status == "Waiting Payment")
                                                                    <button type="button" name="btnAddChargeEdit_{{$exitem->id}}" id="btnAddChargeEdit_{{$exitem->id}}" data-id="{{$exitem->id}}" value="+" class="btnExtraEdit" title="Update" style="background-color:#000; color:#fff; font-weight:600; width:20px; margin-right:2px; float:left; padding:0px;"><i class ="fa fa-save"></i> </button>
                                                                    @if($exitem->invoice_id == null || $exitem->invoice_id == "" || $exitem->invoice_id == "0")
                                                                    <input type="button" name="btnAddChargeDel_{{$exitem->id}}" id="btnAddChargeDel_{{$exitem->id}}" data-id="{{$exitem->id}}" value="-" class="btnExtraDelete" title="Delete" style="background-color:#000; color:#fff; font-weight:600;width:20px;"/>
                                                                    @endif
                                                                @endif
                                                                </td>
                                                                @else
                                                                <td colspan="2" style="padding:0;">{{$exitem->status}}</td>
                                                                @endif                                                                
                                                            </tr>
                                                            @endif
                                                            @endforeach
                                                        </table>
                                                        <span style="width:100%; text-align:right; display:inline-block; margin-top:15px;">
                                                            <input type="button" name="btnAdditionalRequest" id="btnAdditionalRequest" value="Request additional charge" />
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:0">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:5px; border:1px solid #000;">
                                                        <label style="float:right;font-weight:600; color:#000; width:100%;">Refunds:</label>
                                                        <table style="width:100%;" id="tblRefunds">
                                                            <tr>
                                                                <th style="width:35%;">Invoice number</th>
                                                                <th style="width:35%;">Amount (gross)</th>
                                                                <th>Status</th>
                                                                <th style="width:20px;"></th>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:0;">
                                                                    <select name="txtInvoiceNo" id="txtInvoiceNo" style="width:95%;">
                                                                        <option value="" data-val=""></option>
                                                                        @foreach($invoices as $invoice_item)
                                                                        @if($invoice_item->status == 'Paid' || $invoice_item->status == 'Confirmed')
                                                                        <option value="{{$invoice_item->id}}" data-val="{{$invoice_item->invoice_amount}}">{{$invoice_item->id}}</option>
                                                                        @endif
                                                                        @endforeach
                                                                    </select>                                                                   
                                                                </td>
                                                                <td style="padding:0;">
                                                                    <input type="text" name="txtRefundAmount" id="txtRefundAmount" value="" style="width:95%;" />
                                                                </td>
                                                                <td style="padding:0;">
                                                                    <select name="txtRefundStatus" id="txtRefundStatus" style="width:95%;">
                                                                        <option value="Pending">Pending</option>
                                                                        <option value="Done">Done</option>
                                                                    </select>                                                                    
                                                                </td>
                                                                <td style="padding:0;">
                                                                    <input type="button" name="btnAddRefund" id="btnAddRefund" value=" + "  style="background-color:#000; color:#fff; font-weight:600;"/>
                                                                </td>
                                                            </tr>
                                                            @foreach($refunds as $ritem)
                                                                <tr>
                                                                    <td style="padding:0;">
                                                                        <input type="text" name="txtInvoiceNo_{{$ritem->id}}" id="txtInvoiceNo_{{$ritem->id}}" value="{{$ritem->invoice_id}}" class="RefundInviceIdx" style="width:95%;" readonly />
                                                                    </td>
                                                                    <td style="padding:0;">
                                                                        <input type="text" name="txtRefundAmount_{{$ritem->id}}" id="txtRefundAmount_{{$ritem->id}}" value="{{$ritem->refund_amout}}" style="width:95%;" readonly />
                                                                    </td>
                                                                    <td style="padding:0;">
                                                                        <select name="txtRefundStatus_{{$ritem->id}}" id="txtRefundStatus_{{$ritem->id}}" style="width:95%;">
                                                                            @if($ritem->status == "Pending")
                                                                                <option value="Pending">Pending</option>
                                                                                <option value="Done">Done</option>
                                                                            @else
                                                                                <option value="Done">Done</option>
                                                                                <option value="Pending">Pending</option>
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td style="padding:0;">
                                                                    <input type="hidden" name="rCrNote_{{$ritem->id}}" id="rCrNote_{{$ritem->id}}" class="rCrNotex" value="{{$ritem->credit_note_id}}" />
                                                                    <button type="button" name="btnAddRefund_{{$ritem->id}}" id="btnAddRefund_{{$ritem->id}}" data-id="{{$ritem->id}}" class="btnEditRefund" title="Update Status"  style="background-color:#000; color:#fff; font-weight:600; width:20px; padding:0px;"><i class ="fa fa-save"></i> </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                        <span style="width:100%; text-align:right; display:inline-block; margin-top:15px;">
                                                            <input type="button" name="btnRefundSave" id="btnRefundSave" value="Save & Update" />
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:0">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:5px; border:1px solid #000;">
                                                        <label style="float:right;font-weight:600; color:#000; width:100%;">Contact details:</label>
                                                            <span style="width:100%;display:inline-block; text-align:left; padding:3px;">Name & Surname: <input type="text" name="txtContactName" id="txtContactName" value="{{$reqItem->contact_name}}" style="min-width:300px;" disabled /></span>
                                                            <span style="width:100%;display:inline-block; text-align:left; padding:3px;">Email address:<input type="text" name="txtContactEmail" id="txtContactEmail" value="{{$reqItem->contact_email}}" style="min-width:300px;" disabled /></span>
                                                            <span style="width:100%;display:inline-block; text-align:left; padding:3px;">Phone number: <input type="text" name="txtContactPhone" id="txtContactPhone" value="{{$reqItem->contact_full_phone}}" style="min-width:300px;" disabled /></span>
                                                            <span style="width:30%; text-align:left; display:inline-block;"><input type="button" name="btnContactEdit" id="btnContactEdit" value="Edit" style="width:80px;"></span>
                                                       
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:0">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:5px; border:1px solid #000;">
                                                        <label style="float:right;font-weight:600; color:#000; width:100%;">Internal comment:</label>
                                                        <span style="width:100%; text-align:left; display:inline-block; margin-top:5px;">
                                                        <textarea type="text" name="txtComment" id="txtComment" style="width:100%;">{{$reqItem->intenal_note}}</textarea>
                                                        </span>
                                                        <span style="width:100%; text-align:right; display:inline-block; margin-top:15px;">
                                                            <input type="button" name="btnCommentSave" id="btnCommentSave" value=" Save " />
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding:0">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    
                                                    <td colspan="4" style="padding:5px; border:1px solid #000;">
                                                        <label style="float:right;font-weight:600; color:#000; width:100%;">Invoice:</label>
                                                        <table style="width:100%;" id="tblAdditionalCharges">
                                                            <tr>
                                                                <th style="width:40%;">Document number</th>
                                                                <th>Type</th>
                                                                <th style="width:35%;">Amount (gross)</th>
                                                                
                                                            </tr>
                                                            <?php
                                                            $invoice_count = 0;
                                                            ?>
                                                            @foreach($invoices as $inv)
                                                             <tr>
                                                                <td style="width:40%;"><a href="javascript:" data-id="{{$inv->id}}" class="invoicePreview">{{$inv->id}}</a></td>
                                                                <td>Invoice</td>
                                                                <td style="width:35%;">{{$inv->invoice_amount}}</td>
                                                                
                                                            </tr>
                                                            <?php
                                                             if($inv->invoice_type  == "Invoice")
                                                                $invoice_count++;
                                                             ?>
                                                            @endforeach
                                                            @foreach($credit_notes as $cre)
                                                             <tr>
                                                                <td style="width:40%;"><a href="javascript:" data-id="{{$cre->id}}" class="creditNotePreview">{{$cre->id}}</a></td>
                                                                <td>Credit Note</th>
                                                                <td style="width:35%;">{{$cre->amount}}</td>
                                                                
                                                            </tr>
                                                                @endforeach
                                                        </table>
                                                        <span style="width:100%; text-align:right; display:inline-block; margin-top:15px;">
                                                            <input type="hidden" name="curInvoiceCount" id="curInvoiceCount" value="{{$invoice_count}}" />
                                                            <input type="button" name="btnInvoiceGen" id="btnInvoiceGen" value="Generate invoice" />
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>            
                            </div>
                        </div>
                    </div>

                </form>
            </div>


        </div>
        <div class="modal fade" id="additionalAddressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width:500px;">
                <div class="modal-content bg-light">
                    <div class="modal-body p-3 p-md-2">
                        <h3 id="CollectionTitle">{{__('Add Collection Address')}}</h3>
                        <div id="pickupBlock2"  style="height: 250px;">
                                        <span style="width:100%; text-align:left; display:inline-block; max-width:450px; padding:10px 20px;">
                                            <input type="text" name="contact_name1" id="contact_name1" class="form-control" placeholder="Enter name" value="" />
                                        </span>
                                        <span style="width:100%; text-align:left; display:inline-block; max-width:450px; padding:10px 20px;">
                                            <input type="text" name="contact_address1" id="contact_address1" class="form-control" placeholder="Enter address" value="" />
                                        </span>
                                        <span style="width:100%; text-align:left; display:inline-block; margin-bottom:20px; max-width:450px; padding:10px 20px;">
                                            <input type="text" name="contact_phone1" id="contact_phone1" class="form-control" placeholder="Enter phone number" value="" />
                                        </span>

                                        <span style="width:100%; text-align:left; display:inline-block; margin-bottom:20px; max-width:150px; padding:10px 20px;">
                                        <input type="hidden" name="current_order_id" id="current_order_id" value="{{$reqItem->id}}" />
                                        <input type="hidden" name="address_type" id="address_type" value="Pickup" />
                                        <button id="btnAddAddress" type="button" class="btn btn-primary" data-dismiss="modal">{{__("Save")}}</button>
                                    </span>
                                    </div>

                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</button>

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
                        <button type="button" class="close" data-dismiss="modal"
                                style="color: grey; text-decoration: none;" aria-label="Close">
                            <span aria-hidden="true">{{__("&times;")}}</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        If your company has VAT exemption and need a personalized invoice, we recommend to registering or
                        login first
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="InvoiceViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-light">
                    <div class="modal-body p-3 p-md-2">
                        <h3 id="CollectionTitle">{{__('Invoice')}}</h3>
                        <div id="InvoiceData" title="Invoice Preview"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnPrint">{{__("Print")}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="InvoicePdfViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-light">
                    <div class="modal-body p-3 p-md-2">
                        <h3 id="CollectionTitle">{{__('Invoice')}}</h3>
                        <iframe id="pdfBlock" src="" width="100%" height="600px"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="InvoiceDataView" title="Invoice Preview" style="z-index:9999;"></div>

    </section>

    
</div>

    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/printThis.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

$("#datepicker").datepicker({
        showOn: "focus",
        defaultDate: new Date(),
        format : 'dd/mm/yyyy',
        autoclose: true,
    });
   /*     const copyTableBtn = document.getElementById('copy-table');
        const table = document.getElementById('my-table');

        copyTableBtn.addEventListener('click', () => {
            const range = document.createRange();
            range.selectNode(table);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
            alert('Table copied to clipboard!');
        });*/

        let current_order_status = "{{$cur_order_status}}";

        $("#lstPymentMethod").val("{{$cur_payment_method}}");
        $("#orderStatus").val("{{$cur_order_status}}");


        var invoiceType = "{{$user->invoice_type??'Per Order'}}";
if(invoiceType == "Per Order" || invoiceType == ""){
    $("#invoiceType1").prop("checked",true);
}
else{
    if(invoiceType == "Per Week"){
        $("#invoiceType2").prop("checked",true);
    }
    else{
        $("#invoiceType3").prop("checked",true);
    }
}

let excharge1 = "{{$reqItem->help_loading}}";
let excharge2 = "{{$reqItem->help_unloading}}";
let excharge3 = "{{$reqItem->tail_lift}}";
let excharge4 = "{{$reqItem->pickup_weekend}}";
let excharge5 = "{{$reqItem->pickup_same_day}}";
let excharge6 = "{{$reqItem->pickup_delelivery_same_country}}";
let excharge7_type = "{{$reqItem->van_type}}";

let excharge7 = "false";
if(excharge7_type == 'Curtain Sider'){
    excharge7 = "true";
}

let curchargesX="";


if(excharge1 == "true"){
    $("#exCharge1").prop("checked",true);
    if(current_order_status != "Waiting Payment" && current_order_status != "Deferred Payment"){
        $("#exCharge1").attr('disabled','disabled');
    }
    curchargesX="0";
}
if(excharge2 == "true"){
    $("#exCharge2").prop("checked",true);
    if(current_order_status != "Waiting Payment" && current_order_status != "Deferred Payment"){
        $("#exCharge2").attr('disabled','disabled');
    }
    if(curchargesX==""){
        curchargesX="1";
    }
    else{
        curchargesX +=",1";
    }
}
if(excharge3 == "true"){
    $("#exCharge3").prop("checked",true);
    if(current_order_status != "Waiting Payment" && current_order_status != "Deferred Payment"){
        $("#exCharge3").attr('disabled','disabled');
    }
    if(curchargesX==""){
        curchargesX="2";
    }
    else{
        curchargesX +=",2";
    }
}
if(excharge4 == "true"){
    $("#exCharge4").prop("checked",true);
    if(current_order_status != "Waiting Payment" && current_order_status != "Deferred Payment"){
        $("#exCharge4").attr('disabled','disabled');
    }
    if(curchargesX==""){
        curchargesX="3";
    }
    else{
        curchargesX +=",3";
    }
}
if(excharge5 == "true"){
    $("#exCharge5").prop("checked",true);
    if(current_order_status != "Waiting Payment" && current_order_status != "Deferred Payment"){
        $("#exCharge5").attr('disabled','disabled');
    }
    if(curchargesX==""){
        curchargesX="4";
    }
    else{
        curchargesX +=",4";
    }
}
if(excharge6 == "true"){
    $("#exCharge6").prop("checked",true);
    if(current_order_status != "Waiting Payment" && current_order_status != "Deferred Payment"){
        $("#exCharge6").attr('disabled','disabled');
    }
    if(curchargesX==""){
        curchargesX="5";
    }
    else{
        curchargesX +=",5";
    }
}

if(excharge7 == "true"){
    $("#exCharge7").prop("checked",true);
    if(current_order_status != "Waiting Payment" && current_order_status != "Deferred Payment"){
        $("#exCharge7").attr('disabled','disabled');
    }
    if(curchargesX==""){
        curchargesX="6";
    }
    else{
        curchargesX +=",6";
    }
}
if(current_order_status == "Waiting Payment" && current_order_status == "Deferred Payment"){
    $("#currentExCharges").val(curchargesX);
}

$(".exChargeX").click(function(){
    let charge = $(this).attr('data-val');
    let order_tot = $("#order_total").val();
    let current_charges = $("#currentExCharges").val();
    let new_charges = $("#newExCharges").val();
    let remove_charges = $("#removeExCharges").val();
    let currentArr = current_charges.split(",");
    let newArr = "";
    let removeArr = "";
    if(new_charges != ""){
        newArr = new_charges.split(",");
    }
    if(remove_charges != ""){
        removeArr = remove_charges.split(",");
    }
    let cur_tot = 0;

    if($(this).is(':checked')){
        cur_tot = (parseFloat(order_tot) + parseFloat(charge));
        let elementIndex = $(this).attr('data-id');

        if(currentArr.indexOf(elementIndex) == -1){
            if(newArr == ""){
                newArr = elementIndex;
                $("#newExCharges").val(newArr);
            }
            else{
                if(newArr != ""){
                    if(newArr.indexOf(elementIndex) == -1){
                        newArr += "," +  elementIndex;
                        $("#newExCharges").val(newArr);
                    }
                }

                if(removeArr != ""){
                    if(removeArr.indexOf(elementIndex) != -1){
                        removeArr = $.grep(removeArr, function(value) {
                            return value != elementIndex;
                        });
                        $("#removeExCharges").val(removeArr);
                    }
                }
            }
        }

        if(currentArr.indexOf(elementIndex) != -1){
            if(removeArr != ""){
                    if(removeArr.indexOf(elementIndex) != -1){
                        removeArr = $.grep(removeArr, function(value) {
                            return value != elementIndex;
                        });
                        $("#removeExCharges").val(removeArr);
                    }
                }
        }

    }
    else{
        cur_tot = (parseFloat(order_tot) - parseFloat(charge));
        let elementIndex = $(this).attr('data-id');

        if(newArr != ""){
            if(newArr.indexOf(elementIndex) != -1){
                newArr = $.grep(newArr, function(value) {
                            return value != elementIndex;
                        });
                        $("#newExCharges").val(newArr);
                }
        }

        if(currentArr.indexOf(elementIndex) != -1){
        if(removeArr == ""){
            removeArr = elementIndex;
                $("#removeExCharges").val(removeArr);
            }
            else{
                if(removeArr.indexOf(elementIndex) == -1){
                    removeArr += "," +  elementIndex;
                        $("#removeExCharges").val(removeArr);
                }
            }
        }
    }

    if(current_order_status == "Waiting Payment" || current_order_status == "Deferred Payment")
    {
        $("#order_total").val(cur_tot);

        $(".OrderTotX").text(cur_tot.toLocaleString('en-US'));
        $("#txtTotalPrice").val(cur_tot.toFixed(2));
    }
});

let carrierIdX = "{{$reqItem->carrier_id}}";

$("#carrier").val(carrierIdX);

        $("#btnCollection1").click(function(){
           $("#contact_name1").val('');
           $("#contact_address1").val('');
           $("#contact_phone1").val('');
           $("#CollectionTitle").text('Add Collection Address');
           $("#address_type").val('Pickup');
           $("#additionalAddressModal").modal();
        });

        $("#btnCollection2").click(function(){
           $("#contact_name1").val('');
           $("#contact_address1").val('');
           $("#contact_phone1").val('');
           $("#CollectionTitle").text('Add Delivery Address');
           $("#address_type").val('Delivery');
           $("#additionalAddressModal").modal();
        });


        $("#btnAddAddress").click(function(){
            $order_id = $("#current_order_id").val();
            $order_type = $("#address_type").val();
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.add_order_address') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        order_id: $order_id,
                        type: "New",
                        address_type: $order_type,
                        contact_name:$("#contact_name1").val(),
                        contact_address:$("#contact_address1").val(),
                        contact_phone:$("#contact_phone1").val()
                    },
                    success: function (data) {
                        $("#contact_name1").val('');
                        $("#contact_address1").val('');
                        $("#contact_phone1").val('');
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
        });

        $("#btnEdit1").click(function(){
            let str = $(this).val();
            if(str == "Edit"){
                $("#pickupName").removeAttr('disabled','disabled');
                $("#pickupAddress").removeAttr('disabled','disabled');
                $("#pickupPhone").removeAttr('disabled','disabled');
                $(this).val('Save');
            }
            if(str == "Save"){
                $order_id = $("#current_order_id").val();
                $address_type = "Pickup";

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.edit_order_info') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: $order_id,
                        type: $address_type,
                        pickup_name:$("#pickupName").val(),
                        pickup_address:$("#pickupAddress").val(),
                        pickup_phone:$("#pickupPhone").val()
                    },
                    success: function (data) {
                        $("#pickupName").attr('disabled','disabled');
                        $("#pickupAddress").attr('disabled','disabled');
                        $("#pickupPhone").attr('disabled','disabled');
                        $("#btnEdit1").val('Edit');
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
            }
        });

        $("#btnEdit2").click(function(){
            let str = $(this).val();
            if(str == "Edit"){
                $("#receiverName").removeAttr('disabled','disabled');
                $("#receiverAddress").removeAttr('disabled','disabled');
                $("#receiverPhone").removeAttr('disabled','disabled');
                $(this).val('Save');
            }
            if(str == "Save"){
                $order_id = $("#current_order_id").val();
                $address_type = "Delivery";

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.edit_order_info') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: $order_id,
                        type: $address_type,
                        deliver_name:$("#receiverName").val(),
                        deliver_address:$("#receiverAddress").val(),
                        deliver_phone:$("#receiverPhone").val()
                    },
                    success: function (data) {
                        $("#receiverName").attr('disabled','disabled');
                        $("#receiverAddress").attr('disabled','disabled');
                        $("#receiverPhone").attr('disabled','disabled');
                        $("#btnEdit2").val('Edit');
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
            }
        });

        $("#btnEdit3").click(function(){
            let str = $(this).val();
            if(str == "Edit"){
                $("#customer_note").removeAttr('disabled','disabled');
                $(this).val('Save');
            }
            if(str == "Save"){
                $order_id = $("#current_order_id").val();
                $type = "customer_note";

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.edit_order_info') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: $order_id,
                        type: $type,
                        customer_note:$("#customer_note").val(),
                    },
                    success: function (data) {
                        $("#customer_note").attr('disabled','disabled');
                        $("#btnEdit3").val('Edit');
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
            }
        });

        $("#btnContactEdit").click(function(){
            let str = $("#btnContactEdit").val();

            if(str == "Edit"){
                $("#txtContactName").removeAttr('disabled','disabled');
                $("#txtContactEmail").removeAttr('disabled','disabled');
                $("#txtContactPhone").removeAttr('disabled','disabled');
                $(this).val('Save');
            }

            if(str == "Save"){
                let order_id = $("#current_order_id").val();
                let address_type = "ContactAddress";

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.edit_order_info') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: order_id,
                        type: address_type,
                        contact_name:$("#txtContactName").val(),
                        contact_email:$("#txtContactEmail").val(),
                        contact_phone:$("#txtContactPhone").val()
                    },
                    success: function (data) {
                        $("#txtContactName").attr('disabled','disabled');
                        $("#txtContactEmail").attr('disabled','disabled');
                        $("#txtContactPhone").attr('disabled','disabled');
                        $("#btnContactEdit").val('Edit');
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
            }

        });

        $(document).on("click", ".btnOrderAddressEdit", function(){
            let Id = $(this).attr('data-id');
            let btnObjId = "btnPickupEdit_" + Id;
            let str = $(this).val();

            if(str == "Edit"){
                $("#orderExName_" + Id).removeAttr('disabled','disabled');
                $("#orderExAddress_" + Id).removeAttr('disabled','disabled');
                $("#orderExTel_" + Id).removeAttr('disabled','disabled');
                $(this).val('Save');
            }

            if(str == "Save"){
                let order_id = $("#current_order_id").val();
                let address_type = "Edit";

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.add_order_address') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: Id,
                        type: "Edit",
                        order_address_name:$("#orderExName_" + Id).val(),
                        order_address_address:$("#orderExAddress_" + Id).val(),
                        order_address_phone:$("#orderExTel_" + Id).val()
                    },
                    success: function (data) {
                        $("#orderExName_" + Id).attr('disabled','disabled');
                        $("#orderExAddress_" + Id).attr('disabled','disabled');
                        $("#orderExTel_" + Id).attr('disabled','disabled');
                        $("#" + btnObjId).val('Edit');
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
            }
        });

        $(document).on("click", ".btnOrderAddressDelete", function(){
            let Id = $(this).attr('data-id');

            if(confirm("Are you sure?")){
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.add_order_address') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: Id,
                        type: "Delete",
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
            }
        });


        $("#btnSave1").click(function(){
                let order_id = $("#current_order_id").val();
                let pickup_dt = $("#datepicker").val();
                let tot_price = $("#txtTotalPrice").val();
                let status = $("#orderStatus").val();
                let carrier_price = $("#txtCarrierOfferd").val();
                let carrier_id = $("#carrier").val();
                let payment_method = $("#lstPymentMethod").val();
                let type = "update";

              //  let pickup_dt_arr = pickup_dt.split("/");
               // let pickup_date = pickup_dt[2] + "-" + pickup_dt[1] + "-" + pickup_dt[0];


                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.edit_order_info') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: order_id,
                        type: type,
                        pickup_date: pickup_dt,
                        tot_price: tot_price,
                        status: status,
                        carrier_id: carrier_id,
                        carrier_price: carrier_price,
                        payment_method: payment_method
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
        });

        $("#btnCommentSave").click(function(){
            let order_id = $("#current_order_id").val();
            let type = "internal_note";

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('admin.edit_order_info') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: order_id,
                        type: type,
                        internal_note:$("#txtComment").val(),
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });
        });

        $("#exCharge7").click(function(){
            if($("#exCharge7").is(':checked')){
                $("#carrierType").val('Curtain Sider');
            }
            else{
                $("#carrierType").val('box');
            }
        });

        $("#carrierType").change(function(){
            $("#exCharge7").trigger("click");            
        });


        $("#btnExtra").click(function(){

            let charge1 = "false";
            let charge2 = "false";
            let charge3 = "false";
            let charge4 = "false";
            let charge5 = "false";
            let charge6 = "false";

            if($("#exCharge1").is(':checked')){
                charge1 = "true";
            }
            if($("#exCharge2").is(':checked')){
                charge2 = "true";
            }
            if($("#exCharge3").is(':checked')){
                charge3 = "true";
            }
            if($("#exCharge4").is(':checked')){
                charge4 = "true";
            }
            if($("#exCharge5").is(':checked')){
                charge5 = "true";
            }
            if($("#exCharge6").is(':checked')){
                charge6 = "true";
            }

            if($("#exCharge7").is(':checked')){
                charge7 = "true";
            }

            let allCharges = $("#txtExPrice1").val() + "," + $("#txtExPrice2").val() + "," + $("#txtExPrice3").val() + "," + $("#txtExPrice4").val() + "," + $("#txtExPrice5").val() + "," + $("#txtExPrice6").val() + "," + $("#txtExPrice7").val();
           

            let order_id = $("#current_order_id").val();
            let order_tot = $("#order_total").val();
            let van_type = $("#carrierType").val();

            let current_charges = $("#currentExCharges").val();
            let new_charges = $("#newExCharges").val();
            let remove_charges = $("#removeExCharges").val();


            let type = "extra";

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                 $.ajax({
                    url: "{{ route('admin.edit_order_info') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: order_id,
                        type: type,
                        van_type:van_type,
                        tot_price:order_tot,
                        charge1:charge1,
                        charge2:charge2,
                        charge3:charge3,
                        charge4:charge4,
                        charge5:charge5,
                        charge6:charge6,
                        currentCharges:current_charges,
                        newCharges:new_charges,
                        removeCharges:remove_charges,
                        allcharges:allCharges,
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        $("#newExCharges").val('');
                        $("#removeExCharges").val('');
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
                });

        });

        $("#btnAddCharge").click(function(){
            let user_id = $("#user_id").val();
            let order_id = $("#order_id").val();
            let requester = $("#txtExtraRequester").val();
            let amount = $("#txtExtraAmount").val();
            let status = $("#lstExtraStatus").val();
            let payment_method = $("#lstPymentMethod").val();
            let type = "New";

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            
                    $.ajax({
                    url: "{{ route('admin.manage_additional_charges') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        type: type,
                        user_id: user_id,
                        order_id: order_id,
                        requester: requester,
                        amount: amount,
                        status: status,
                        payment_method:payment_method,
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        $("#txtExtraRequester").val('');
                        $("#txtExtraAmount").val('');
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
        });

        $(".btnExtraEdit").click(function(){
            let objId = $(this).attr('data-id');
            let user_id = $("#user_id").val();
            let order_id = $("#order_id").val();
            let requester = $("#txtExtraRequester_" + objId).val();
            let amount = $("#txtExtraAmount_" + objId).val();
            let status = $("#lstExtraStatus_" + objId).val();
            let payment_method = $("#lstPymentMethod").val();
            let type = "Edit";
            let msg = "";
            
                if(requester == "")
                {
                    msg = "Requester cannot be empty!";
                }
                if(amount == "")
                {
                    msg += "\nAmount cannot be empty!";
                }

                if(msg != ""){
                    alert(msg);
                }
                else{

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            
                    $.ajax({
                    url: "{{ route('admin.manage_additional_charges') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        type: type,
                        id: objId,
                        user_id: user_id,
                        order_id: order_id,
                        requester: requester,
                        amount: amount,
                        status: status,
                        payment_method: payment_method,
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
                }
        });

        $(".btnExtraDelete").click(function(){
            let objId = $(this).attr('data-id');
            if(confirm("Are you sure?"))
            {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            
                    $.ajax({
                    url: "{{ route('admin.manage_additional_charges') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        type: 'Delete',
                        id: objId,
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
            }

        });


        $("#btnAdditionalRequest").click(function(){
            let order_id = $("#order_id").val();
            let payment_method = $("#lstPymentMethod").val();

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            
                    $.ajax({
                    url: "{{ route('admin.request_additional_charges') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        order_id: order_id,
                        payment_method:payment_method,
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
        });

        $("#btnInvoiceGen").click(function(){
            let cur_order_status = "{{$reqItem->status}}";

            if(cur_order_status == "Paid" || cur_order_status == "Confirm")
            {
            let order_id = $("#order_id").val();
            let invoice_count = $("#curInvoiceCount").val();
            if(invoice_count == 0){
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            
                    $.ajax({
                    url: "{{ route('admin.new_invoice_gen') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        order_id: order_id,
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
            }
            else{
                Command: toastr["error"]("Invoice already exists!", "Error");
            }
        }
        else{
            Command: toastr["error"]("Invoice status should be Paid or Confirm!", "Error");
        }
        });

        $("#txtInvoiceNo").change(function(){
            let Id = $(this).val();
            let amount = $("#txtInvoiceNo option:selected").attr('data-val');
            $("#txtRefundAmount").val(amount);
        });


        $("#btnAddRefund").click(function(){
            let order_id = $("#order_id").val();
            let invoice_id = $("#txtInvoiceNo").val();
            let amount = $("#txtRefundAmount").val();
            let status = $("#txtRefundStatus").val();
            let refundId = 0;
            let InvoiceFlag = "Yes";

            $(".RefundInviceIdx").each(function(){
                if($(this).val() == invoice_id){
                    InvoiceFlag = "No";
                }
            });


            if(InvoiceFlag == "Yes"){
            if(parseInt(invoice_id) > 0 && parseFloat(amount) > 0){
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url: "{{ route('admin.manage_refund') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id:0,
                        invoice_id: invoice_id,
                        order_id: order_id,
                        amount: amount,
                        status: status
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
            
            }
            else{
                Command: toastr["error"]("Invoice Id and/or Amount is invalid ", "Error");
            }
        }
        else{
            Command: toastr["error"]("Selected invoice refund record already exists! Click Save and update button first", "Error");
        }
        });

        $(document).on("click",".btnEditRefund", function(){
            let Id = $(this).attr('data-id');
            let status = $("#txtRefundStatus_" + Id).val();

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url: "{{ route('admin.manage_refund') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: Id,
                        status: status
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
        });

        $("#btnRefundSave").click(function(){
            var rowCount = $('#tblRefunds tr').length;
            if(rowCount > 2){
                let newItemCount = 0;
                $(".rCrNotex").each(function(){
                    let curId = $(this).val();
                    if(curId == 0){
                        newItemCount++;
                    }
                });

                if(newItemCount > 0){
                    let order_id = $("#order_id").val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url: "{{ route('admin.create_credit_note') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        order_id: order_id
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        location.reload();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });

                }
                else{
                    Command: toastr["error"]("New refund records not found!", "Error");
                }
            }
            else{
                Command: toastr["error"]("Refund records not found!", "Error");
            }
        });

        $("#btnSend1").click(function(){
            let order_id = $("#order_id").val();
            let carrier_id = $("#carrier").val();

            if(carrier_id != ""){
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url: "{{ route('admin.send_carrier_email') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        order_id: order_id,
                        carrier_id: carrier_id
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });

            }
            else{
                Command: toastr["error"]("Carrier not selected", "Error");
            }

        });


        $("#btnPaymentLink").click(function(){
            let order_id = $("#order_id").val();

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url: "{{ route('admin.payment_link_email') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: order_id
                    },
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
        });

    $(document).on('click', '.invoicePreview', function () {
            var ItemId = $(this).attr('data-Id');
          //  let application_url = "/admin/invoice_view/" + ItemId;

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url:  "/admin/invoice_pdf_view/" + ItemId,
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
                        $("#pdfBlock").attr("src", "/admin/display_pdf/" + data.data);
                        $("#InvoicePdfViewModal").modal();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
        });

        $(document).on('click', '.creditNotePreview', function () {
            var ItemId = $(this).attr('data-Id');
          //  let application_url = "/admin/invoice_view/" + ItemId;

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url:  "/admin/credit_note_pdf/" + ItemId,
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
                        $("#pdfBlock").attr("src", "/admin/display_pdf/" + data.data);
                        $("#InvoicePdfViewModal").modal();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
        });

      /*  $(document).on('click', '.invoicePreview', function () {
            var ItemId = $(this).attr('data-Id');
          //  let application_url = "/admin/invoice_view/" + ItemId;

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url: "{{ route('admin.invoice_view') }}",
                    type: "POST",
                    dataType: 'json',
                    data:{
                        id: ItemId
                    },
                    success: function (data) {
                        $("#InvoiceData").html(data.data);
                        $("#InvoiceViewModal").modal();
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });
        });*/

               
 /*
        $("#btnPrint").click(function(){
            $("#InvoiceData").printThis();
        });


       $(document).on('click', '.invoicePreview', function () {
            var ItemId = $(this).attr('data-Id');
            let url = "/admin/invoice_pdf_view/" + ItemId;

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                    url: "/admin/invoice_pdf_view/" + ItemId,
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
                        $invoice_path = data.data;
                        $("#InvoiceDataView").dialog({
                            modal: false,
                            title: 'Invoice Preview',
                            width: 1200,
                            height: 700,
                            buttons: {
                                Close: function () {
                                    $(this).dialog('close');
                                }
                            },
                            open: function () {
                                var object = "<object data=\"{FileName}\" type=\"application/pdf\" width=\"1200px\" height=\"700px\">";
                                object += "</object>";
                                object = object.replace(/{FileName}/g, $invoice_path);
                                $("#InvoiceDataView").html(object);
                                $(".ui-dialog-titlebar-close").html("<span style='position: absolute;top: -2px;left: 3px;'>X</span>");
                            }
                        });
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");
                    }
             });

        });*/

    </script>
@endsection
