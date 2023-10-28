@extends("layouts.app")

@section("style")
    <link rel="stylesheet" href="{{ asset('css/invoice.css?v=0.0.1') }}">
@endsection

@section("content")
    <div class="container bootstrap snippets bootdeys">
        <div class="row">



            <div class="col-sm-12">
                <form class="panel panel-default invoice" id="invoice">
                    @csrf
                    <div class="panel-body">
                        @foreach($reqItems as $key => $reqItem)

                            <div class="row">

                                <div class="col-sm-6 top-left">
                                    <a href="{{url('admin/adminRequest/'.$reqItems->first()->id .'/edit')}}" onclick="$('#price_form').submit()" type="button" style="color: #D3D3D3;" style="color: #D3D3D3;" class="fa fa-arrow-left"></a>
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>

                                <div class="col-sm-6 top-right">
                                    <p class="d-none" id="req_id">{{ $reqItem->id }}</p>
                                    <h3 class="marginright">{{ $reqItem->order_number }}</h3>
                                    <span class="marginright today-show">2022-09-30</span>
                                </div>

                            </div>
                            <hr>
                        {{--{{dd(session()->all())}}--}}
                            <div class="row">

                                <div class="col-4 from who-info">
                                    <p class="lead marginbottom">From : {{ $reqItem->sender }}</p>
                                    <p>{{ $reqItem->sender_city}}</p>
                                    <p>{{__('Phone:')}} {{getCodeByFullCountryName(session('price_page')['pickup_country']) . $reqItem->sender_phone}}</p>
                                </div>

                                <div class="col-4 to who-info">
                                    <p class="lead marginbottom">To : {{ $reqItem->receiver }}</p>
                                    <p>{{ $reqItem->receiver_city }}</p>
                                    <p>{{__('Phone:')}} {{getCodeByFullCountryName(session('price_page')['desti_country']).  $reqItem->receiver_phone }}</p>
                                </div>


                                <div class="col-4 payment-details">
                                    <p class="lead marginbottom payment-info">{{__('Contact details')}}</p>
                                    <p>Collection Date: {{ $reqItem->collection_day }}</p>
                                    <p>Name: {{ $reqItem->contact_name}}</p>
                                    <p>{{__('Email: ')}}<span id="contact_email">{{ $reqItem->contact_email}}</span></p>
                                    <p>{{__('Phone:')}} {{getCodeByFullCountryName(session('price_page')['pickup_country']). $reqItem->contact_phone }}</p>

                                </div>

                            </div>

                            <div class="row table-row">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width:20%">{{__('Van Type')}}</th>
                                        <th class="text-right" style="width:20%">{{__('Add-ons')}}</th>
                                        <th class="text-right" style="width:40%">{{__('Content')}}</th>
                                        <th class="text-right" style="width:20%">{{__('Value')}}</th>
                                        <th class="text-right" style="width:20%">{{__('Special Notes')}}</th>
                                        <th class="text-right" style="width:40%">{{__('Distance')}}</th>
                                        <th class="text-right" style="width:40%">{{__('Duration')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $reqItem->van_type }}</td>
                                        <td class="text-right d-none">
                                            <p id="help_loading">{{ $reqItem->help_loading }}</p>
                                            <p id="help_unloading">{{ $reqItem->help_unloading }}</p>
                                            <p id="tail_lift">{{ $reqItem->tail_lift }}</p>
                                        </td>
                                        <td class="text-right">
                                            <p id="help_loading_show" class="help_show"></p>
                                            <p id="help_unloading_show" class="help_show"></p>
                                            <p id="tail_lift_show" class="help_show"></p>
                                        </td>
                                        <td class="text-right">{{ $reqItem->cargo_info }}</td>
                                        <td class="text-right">{{ $reqItem->cargo_val }}</td>
                                        <td class="text-right">{{ $reqItem->contact_note  ?? 'N/A'}}}</td>
                                        <td class="text-right">{{ $reqItem->distance }}</td>
                                        <td class="text-right">{{ $reqItem->duration }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="row my-3">
                                <div class="col-6 invoice-total">
                                    <p class="d-none">What Vat :
                                        <span class="total-price" id="vat_state">{{ $reqItem->user_vat }}</span>
                                    </p>
                                    <p>SubTotal :
                                        <span><b>€</b></span>
                                        @if(!auth()->check() ||  (auth()->check() &&  auth()->user()->vat_check() == false))
                                            <span class="total-price" id="sub_price"><?= round($reqItem->price  / 1.19, 2); ?> </span>

                                            @else
                                            <span class="total-price" id="sub_price"> {{$reqItem->price}} </span>
                                            @endif
                                    </p>
                                    <p>VAT
                                        <span class="vat_valid">(%)</span>
                                        <span > : <b>€</b></span>
                                        <span class="total-price" id="vat_price"></span>
                                    </p>
                                    <p>Total :
                                        <span ><b>€</b></span>
                                        <span class="total-price" id="total_price"></span>
                                    </p>
                                </div>

                                <div class="col-6 margintop">
                                    <button class="btn btn-success" id="invoice_next">{{__('Continue')}}</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var today = new Date().toISOString().slice(0, 10);
        $(".today-show").html(today);

        var vat_state = $("#vat_state").html();
        var sub_price = $("#sub_price").html();
        var contact_email = $("#contact_email").html();
        var req_id = $("#req_id").html();
        @if(!auth()->check() ||  (auth()->check() &&  auth()->user()->vat_check() == false))
        if (vat_state == "true") {
            $(".vat_valid").html("(0%)");
            $("#vat_price").html("0");
            var total_price = sub_price;
            $("#total_price").html("<b>"  +  total_price + "</b>");
        } else if (vat_state == "false" || vat_state == "") {
            $(".vat_valid").html("(19%)");
            var vat_price = sub_price * 0.19;
            var vat_price = vat_price.toFixed(2);
            $("#vat_price").html("<b>"  + vat_price + "</b>");
            var total_price = Number(sub_price) + Number(vat_price);
            var total_price = total_price.toFixed(2);
            $("#total_price").html("<b>"  + total_price + "</b>");
        }
        @else
        $(".vat_valid").html("(0%)");
        $("#vat_price").html("0");
        var total_price = sub_price;
        $("#total_price").html("<b>"  +total_price + "</b>");

        @endif

        var help_loading = $("#help_loading").html();
        var help_unloading = $("#help_unloading").html();
        var tail_lift = $("#tail_lift").html();
        if (help_loading == "true") {
            $("#help_loading_show").html("- Help Loading");
        }
        if (help_unloading == "true") {
            $("#help_unloading_show").html("- Help Unloading");
        }
        if (tail_lift == "true") {
            $("#tail_lift_show").html("- Tail_Lift");
        }


        $("#invoice_next").click(function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('invoice.create') }}",
                data: {
                    total_price: total_price,
                    req_id: req_id
                },
                success: function(data) {
                    if (data.status == '2') {
                        window.location.href = "/payment?price="+btoa(total_price);
                        return false;
                    } else if (data.status == '1') {
                        Command: toastr["error"]("{{__("Database Error")}}", "Error");
                        return false;
                    }
                },
                error: function(data) {
                    if (data.status == '401') {
                        Command: toastr["warning"]("{{__("Please login firstly!")}}", "Warning");
                        setTimeout(() => {
                            window.location.href = "/login";
                        }, "3000")
                        return false;
                    }
                    else {
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




    </script>
@endsection

