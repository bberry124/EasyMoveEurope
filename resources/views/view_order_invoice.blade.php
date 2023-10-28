@extends('layouts.app')
@section('style')
    <style>
        table th{
            text-align:left
        }

    </style>
@endsection
@section("content")
    <br>
    <br>
    <br>
    <br>
    <div class="container bootstrap snippets bootdeys">
        <div class="row mt-5 personal-section">
            <div class="container col-8 col-md-8 personal-infos mb-3">
                <button id="copy-table" type="button" class="btn btn-outline-primary pull-right">Copy</button>

                <table id="my-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th colspan="2">{{__("FROM")}} </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{{__("Country")}}}</td>
                        <td>{{ $reqItem->pickup_country }}</td>
                    </tr>
                    <tr>
                        <td>{{{__("Delivery Address")}}}</td>
                        <td>{{$reqItem->sender_city}}</td>
                    </tr>
                    <tr>
                        <td>{{{__("Sender Name")}}}</td>
                        <td>{{ucfirst($reqItem->sender)}}</td>
                    </tr>
                    <tr>
                        <td>{{{__("Phone Number")}}}</td>
                        <td>{{$reqItem->sender_phone != "" && $reqItem->sender_phone != null  ?  getCodeByFullCountryName($reqItem->pickup_country)  . "  "  .   $reqItem->sender_phone: "" }}</td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="2">{{__("TO")}} </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{{__("Country")}}}</td>
                        <td>{{ $reqItem->desti_country }}</td>
                    </tr>
                    <tr>
                        <td>{{{__("Delivery Address")}}}</td>
                        <td>{{$reqItem->receiver_city}}</td>
                    </tr>
                    <tr>
                        <td>{{{__("Receiver Name")}}}</td>
                        <td>{{$reqItem->receiver}}</td>
                    </tr>
                    <tr>
                        <td>{{{__("Phone Number")}}}</td>
                        <td>{{  $reqItem->receiver_phone != "" && $reqItem->receiver_phone != null  ?  getCodeByFullCountryName($reqItem->desti_country). "  "  . $reqItem->receiver_phone : "" }}</td>
                    </tr>
                    <tr>
                        <td>{{__("Van Type")}}</td>
                        <td>{{ucfirst($reqItem->van_type)}}</td>
                    </tr>
                    <tr>
                        <td>{{__("Extra Services")}}</td>
                        <td>
                            @if($reqItem->help_loading === 'true')
                                - {{__("Help Loading")}}
                            @endif
                            @if($reqItem->help_unloading === 'true')
                                <br>
                                -  {{__("Help Unloading")}}
                            @endif
                            @if($reqItem->tail_lift === 'true')
                                <br>
                                -    {{__("Tail Lift")}}
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <td>{{__("Cargo Information")}}</td>
                        <td>{{$reqItem->cargo_info}}</td>
                    </tr>
                    <tr>
                        <td>{{__("Cargo Value")}}</td>
                        <td>{{$reqItem->cargo_val}}</td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="2">{{__("Contact Details")}} </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{__("Name & Surname")}}</td>
                        <td>{{$reqItem->contact_name}}</td>
                    </tr>

                    <tr>
                        <td>{{__("Email Address")}}</td>
                        <td>{{$reqItem->contact_email}}</td>
                    </tr>
                    <tr>
                        <td>{{__("Phone Number")}}</td>
                        <td>{{  $reqItem->receiver_phone != "" && $reqItem->receiver_phone != null  ?  getCodeByFullCountryName($reqItem->desti_country) . "  "  . $reqItem->contact_phone : ""}}</td>
                    </tr>
                    <tr>
                        <td>{{__("Special Notes")}}</td>
                        <td>{{$reqItem->contact_note}}</td>
                    </tr>
                    <tr>
                        <td>{{__("Distance")}}</td>
                        <td>{{$reqItem->distance}}</td>
                    </tr>

                    <tr>
                        <td>{{__("Duration")}}</td>
                        <td>{{$reqItem->duration}}</td>
                    </tr>
                    <tr>
                        <td>{{__("SubTotal")}}</td>
                        <td>{{getSubTotalPrice($reqItem->total_price ?? $reqItem->price)}}</td>
                    </tr>
                    <tr>
                        <td>{{__("VAT")}}</td>
                        <td>{{validVatOrNot($reqItem->total_price ?? $reqItem->price)}}</td>
                    </tr>
                    <tr>
                        <td>{{__("Total")}}</td>
                        <td>{{$reqItem->total_price ?? $reqItem->price}}</td>
                    </tr>


                    </tbody>
                </table>


            </div>


        </div>
    </div>

    <script>
        const copyTableBtn = document.getElementById('copy-table');
        const table = document.getElementById('my-table');

        copyTableBtn.addEventListener('click', () => {
            const range = document.createRange();
            range.selectNode(table);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
            alert('Table copied to clipboard!');
        });


    </script>
@endsection
