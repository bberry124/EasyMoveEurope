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
        .update_profile {
            min-height: 500px;
            background-size: cover;
            background-position: center;
        }

        
        @media (max-width: 575px) {
            .update_profile {
                padding: 20px;
            }
        }

        .update_profile h3 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .update_profile h4 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0 0 0;
        }

        .update_profile p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .update_profile .error-message {
            display: none;
            color: #fff;
            background: #df1529;
            text-align: left;
            padding: 15px;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .update_profile .sent-message {
            display: none;
            color: #fff;
            background: #059652;
            text-align: center;
            padding: 15px;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .update_profile .loading {
            display: none;
            background: #fff;
            text-align: center;
            padding: 15px;
            margin-bottom: 24px;
        }

        .update_profile .loading:before {
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

        .update_profile input,
        .update_profile textarea {
            box-shadow: none;
            font-size: 14px;
        }

        .gupdate_profile input:focus,
        .update_profile textarea:focus {
            border-color: grey;
        }

        .update_profile textarea {
            padding: 12px 15px;
        }

        .update_profile button {
            background: rgb(54 82 126);
            border: 0;
            padding: 10px 30px;
            color: #fff;
            transition: 0.4s;
            border-radius: 4px;
        }

        .update_profile button:hover {
            background: rgb(37 50 72);
        }


    </style>
    <link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

@endsection


@section('content')
    <section id="update_profile" class="update_profile">
        <div class="container" data-aos="fade-up">
            <div class="row g-0">
            <form id="companyForm" name="companyForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                        <table class="table table-striped" style="background-color:#f2ede7;">
                            <tr>
                                <td colspan="2" style="background-color:#352b53; color:#fff; padding:8px; font-size:18px;"><strong>Business profile</strong></td>
                            </tr>
                            <?php
                                $active = "No";
                                $activated_on = "";
                                $last_login_on = "";
                                if(!is_null($user->email_verified_at))
                                {
                                    $active = "Yes";
                                    $activated_on = date_format($user->email_verified_at, 'd.m.Y H:i:s');
                                }
                                if(!is_null($user->last_login_at)){
                                    $date1 = new DateTimeImmutable($user->last_login_at);
                                    $last_login_on = date_format($date1, 'd.m.Y H:i:s');
                                }
                            ?>
                            <tr>
                                <td class="col-3" style="padding:3px;">Active:</td>
                                <td class="col-9" style="padding:3px;">{{$active}}</td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Registerd on:</td>
                                <td class="col-9" style="padding:3px;">{{date_format($user->created_at, 'd.m.Y H:i:s')}}</td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Activated on:</td>
                                <td class="col-9" style="padding:3px;">{{$activated_on}}</td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Last login on:</td>
                                <td class="col-9" style="padding:3px;">{{$last_login_on}}</td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Impersonation allowed: <br /> Employees can login as that user</td>
                                <td class="col-9" style="padding:3px;">
                                    <div style="width:100%; padding:5px;">
                                        <span style="width:30px; padding:4px; background-color:#fff; border:1px solid #000; margin-right:40px; margin-top:5px;">Yes</span>
                                        <span style="padding:3px; background-color:#f9f9f9; border:1px solid #c1caff;margin-top:5px;">
                                            <a id="LoginAsCompanyLink" href="Javascript:" data-id="{{$user->id}}">Log in as this user <i class="fa fa-external-link"></i></a>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="background-color:#fff; color:#000; padding:5px;">
                                    <div style="width:100%; background-color:#fff;">
                                        <strong>Financial data</strong>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Credit balance:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="text" name="txtCredit" id="txtCredit" value="{{$user->credit_balance}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">VAT ID:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="text" id="uvat" name="vat_name" placeholder="{{__('VAT ID')}}" value="{{$user->vat_name}}" class="col-5" required="">
                                    <input type="hidden" id="valid_vat" name="valid_vat" value="{{$user->valid_vat}}">
                                    <button type="button" onclick="verify_vat($('#uvat').val(), $('#user_id').val())" class="btn btn-info btn-sm" style="padding:4px; margin-left:25px;">{{__("Verify in VIES")}}</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">{{__("VAT Validation Status")}}:</td>
                                <td class="col-9" style="padding:3px;">
                                    <?php
                                    if($user->valid_vat_or_not==true)
                                    {
                                    ?>
                                    <span class="valid_text">{{__("Valid EU VAT ID")}}</span> &nbsp;(<span class="update-valid-vat">0%</span>)
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <span class="valid_text">{{__("Non-valid VAT")}}</span> &nbsp;(<span class="update-valid-vat">19%</span>)
                                    <?php
                                    }
                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Invoices:</td>
                                <td class="col-9" style="padding:3px;">
                                                <span class="col-2" style="text-align:left; display:inline-block;">
                                                    <input type="checkbox" id="invoiceType1" name="chInvoiceType" class="invoiceTypeX" value="Per Order" />
                                                    <label for="invoiceType1" style="width:80%; float:right; padding-top:0px;">Per Order</label>
                                                </span>
                                                <span class="col-2" style="text-align:left; display:inline-block;">
                                                    <input type="checkbox" id="invoiceType2" name="chInvoiceType" class="invoiceTypeX" value="Per Week" />
                                                    <label for="invoiceType2" style="width:80%; float:right; padding-top:0px;">Per Week</label>
                                                </span>
                                                <span class="col-2" style="text-align:left; display:inline-block;">
                                                    <input type="checkbox" id="invoiceType3" name="chInvoiceType" class="invoiceTypeX" value="Per Month" />
                                                    <label for="invoiceType3" style="width:80%; float:right; padding-top:0px;">Per Month</label>
                                                </span>
                                                <input type="hidden" name="invoice_type" id="invoice_type" value="{{$user->invoice_type}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">User order profile:</td>
                                <td class="col-9" style="padding:3px;">
                                    <table style="border:1px solid #000;">
                                        <tr>
                                            <td class="col-2" style="border:1px solid #000; text-align:center; padding:5px;">N.Orders</td>
                                            <td class="col-2" style="border:1px solid #000; text-align:center; padding:5px;">Revenue</td>
                                            <td class="col-2" style="border:1px solid #000; text-align:center; padding:5px;">Margin</td>
                                        </tr>
                                        <tr>
                                            <td class="col-2" style="border:1px solid #000; text-align:center; padding:5px;">{{$tot_orders_count}}</td>
                                            <td class="col-2" style="border:1px solid #000; text-align:center; padding:5px;">{{number_format($paid_amount,2,".",",")}}</td>
                                            <td class="col-2" style="border:1px solid #000; text-align:center; padding:5px;">{{number_format($margin,2,".",",")}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="background-color:#fff; color:#000; padding:5px;">
                                    <div style="width:100%; background-color:#fff;">
                                        <strong>User data</strong>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">User ID:</td>
                                <td class="col-9" style="padding:3px;">{{$user->id}}</td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Contact name:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="text" name="txtContactName" id="txtContactName" class="col-6" value="{{$user->name}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">E-mail:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="email" name="txtContactEmail" id="txtContactEmail" class="col-6" value="{{$user->email}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Additional E-mail:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="email" name="txtContactEmail2" id="txtContactEmail2" class="col-6" value="{{$user->additional_email}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Company:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="text" name="txtCompany" id="txtCompany" class="col-6" value="{{$user->company_name}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Street name & number:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="text" name="txtStreet" id="txtStreet" class="col-6" value="{{$user->location}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Town/City:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="text" name="txtCity" id="txtCity" class="col-6" value="{{$user->city}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Zip code:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="text" name="txtZipcode" id="txtZipcode" class="col-6" value="{{$user->zipcode}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Country:</td>
                                <td class="col-9" style="padding:3px;">
                                <?php
                                    $current_country_key = "";
                                ?>
                                <select id="country" name="country" onchange="getCountryCode($(this).find('option:selected').attr('data-country'))" class="col-6 reg-text @error('country') is-invalid @enderror" required>
                                    
                                    @foreach(allCountries(1) as $country_key => $country)
                                        @if($user->company_country == $country)
                                        $current_country_key = $country_key;
                                        <option data-country="{{$country_key}}" value="{{$loop->iteration > 1 ?  $country : $country_key}}" selected>{{__($country)}}</option>
                                        @else
                                        <option data-country="{{$country_key}}" value="{{$loop->iteration > 1 ?  $country : $country_key}}">{{__($country)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Phone:</td>
                                <td class="col-9" style="padding:3px;">
                                    <input type="text" name="phone" id="phone" class="col-6" value="{{$user->phone}}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3" style="padding:3px;">Internal comments:</td>
                                <td class="col-9" style="padding:3px;">
                                    <textarea name="txtComment" id="txtComment" class="col-6">{{$user->internal_note}}</textarea>
                                </td>
                            </tr>

                            <tr>
                                <td class="col-3" style="padding:8px;">
                                    <input type="button" name="btnSave" id="btnSave" class="btn btn-primary btn-info btm-sm" value="Update & Save" />
                                </td>
                                <td class="col-9" style="padding:8px; text-align:right;">
                                  <input type="button" name="btnDelete" id="btnDelete" class="btn btn-primary btn-danger btm-sm" value="Delete user" />
                                </td>
                            </tr>


                            </form>
                            </table>


                                    <div class="col-md-12">
                                        <table id="orderTable" class="table table-bordered data-table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Date</th>
                                                    <th>Pickup Date</th>
                                                    <th>Order Number</th>
                                                    <th>To pay</th>
                                                    <th>Client Type</th>
                                                    <th>Status</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

            </div>
        </div>
    </section>
<script>

           var table = $('#orderTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/company_profile/" + $('#user_id').val(),
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'collection_day', name: 'collection_day'},
                    {data: 'id', name: 'id'},
                    {data: 'price', name: 'price'},
                    {data: 'who_type', name: 'who_type'},
                    {data: 'status', name: 'status'},
                    {data: 'pickup_country', name: 'pickup_country'},
                    {data: 'desti_country', name: 'desti_country'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

var invoiceType = "{{$user->invoice_type}}";
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

$("#invoiceType1").click(function(){
    if($(this).is(':checked')){
        $("#invoiceType2").prop("checked",false);
        $("#invoiceType3").prop("checked",false);
        $("#invoice_type").val("Per Order");
    }
});

$("#invoiceType2").click(function(){
    if($(this).is(':checked')){
        $("#invoiceType1").prop("checked",false);
        $("#invoiceType3").prop("checked",false);
        $("#invoice_type").val("Per Week");
    }
});

$("#invoiceType3").click(function(){
    if($(this).is(':checked')){
        $("#invoiceType1").prop("checked",false);
        $("#invoiceType2").prop("checked",false);
        $("#invoice_type").val("Per Month");
    }
});

function getCountryCode(value) {


contact_phone = document.getElementById('phone')

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

let cur_country = $('#country').find('option:selected').attr('data-country');

getCountryCode(cur_country);

function verify_vat(value, user_id){

$.post('{{route('admin.verify-vat')}}',{'user_id':user_id, 'vat': value, '_token' : '{{csrf_token()}}'}, function(data){

    if(data == true){
        $("#valid_vat").val('0');
        $(".update-valid-vat").text('0%');
        $(".valid_text").text("{{"Valid VAT ID"}}")
        Command: toastr["success"]("{{__("Valid Vat")}}", "Success");

    }
    else{
        $("#valid_vat").val('1');
        $(".update-valid-vat").text('19%');
        $(".valid_text").text("{{"Non-valid VAT"}}")
        Command: toastr["error"]("{{__("Invalid Vat")}}", "Error");
    }
})
}

//$(".update-valid-vat").html(data.valid_vat_or_not ? '0%' : '19%');
//$(".valid_text").text(data.valid_vat_or_not ? "{{"Valid VAT ID"}}" : "{{"Non-valid VAT"}}");

$("#LoginAsCompanyLink").click(function(){
    let Id=$(this).attr('data-id');
    window.location.href = "/user-proxy/enter/" + Id;
});

$("#btnSave").click(function(){
    var _token = $("input[name='_token']").val();
            var uid = $('#user_id').val();
            var uphone = $('#phone').val();
            var ucountry = $('#country').val();
            var uvat = $('#uvat').val();
            var contact_name = $("#txtContactName").val();
            var email = $("#txtContactEmail").val();
            var email2 = $("#txtContactEmail2").val();
            var company = $("#txtCompany").val();
            var invoiceType = $("#invoice_type").val();
            var note = $("#txtComment").val();
            var credit = $("#txtCredit").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:"{{ route('admin.company_profile_update') }}",
                data:{
                    _token:_token,
                    uid:uid,
                    uphone:uphone,
                    ucountry:ucountry,
                    uvat:uvat,
                    vvat:$("#valid_vat").val(),
                    email:email,
                    additional_email:email2,
                    contact_name: contact_name,
                    company_name: company,
                    location:$("#txtStreet").val(),
                    zipcode:$("#txtZipcode").val(),
                    city:$("#txtCity").val(),
                    invoice_type: invoiceType,
                    internal_note:note,
                    credit_balance:credit,
                },
                success:function(data){
                    if(data.status == '2') {
                        Command: toastr["success"]("{{__("Updated the profile")}}", "Success");
                         location.reload(true);
                    } else if(data.status == '1') {
                        Command: toastr["error"]("{{__("Database Error")}}", "Error");
                        return false;
                    }  else if(data.status == '0') {
                        printErrorMsg(data.error);
                        return false;
                    }
                },
                error: function(data) {
                    if(data.status == '401') {
                        Command: toastr["warning"]("{{__("Please login firstly!")}}", "Warning");
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
});

$("#btnDelete").click(function(){
    var flag = confirm("Are you sure to delete this company user account?");
    if (flag) {
        var user_id = $('#user_id').val();
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
                        type: "DELETE",
                        url: "{{ route('adminCompany.store') }}"+'/'+user_id,
                        success: function (data) {
                            location.href="/admin/adminCompany";
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
    }

});

$(document).on("click",".deleteProduct", function(){
    var flag = confirm("Are you sure to delete this order?");
    if (flag) {
        var order_id = $(this).attr('data-id');
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
                        type: "DELETE",
                        url: "/admin/delete_order/"+order_id,
                        success: function (data) {
                            location.reload();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
    }
});

    </script>
@endsection
