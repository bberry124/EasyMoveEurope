
@section("style")
    <link rel="stylesheet" href="{{ asset('css/invoice.css?v=0.0.1') }}">
@endsection


    <div class="container bootstrap snippets bootdeys">
        <div class="row">
        <div style="width: 100%;">
                <div style="max-width: 630px; background-color: white; width: 100%;padding:15px 5%; border:1px solid #000;">
                    <div style="width: 100%; margin: 0 auto; padding: 0;">
                        <img src="{{$logo_img}}" style="width:250px;" />
                    </div>
                    
                    <div style="margin: 10px auto; min-height: 250px; width: 100%; border-top: 1px solid #000;">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:65%; padding:4px; font-weight:600;">EASY MOVE EUROPE SRL</td>
                                <td style="width:55%; padding:4px;">Invoice to:</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">
                                    Strada Feleacu 3,<br />
                                    077190 Bucharest,<br />
                                    Romania.<br />
                                    VAT: RO47795949<br />
                                </td>
                                <td style="width:65%; padding:4px; vertical-align:text-top;"><strong>{{$order->sender}}</strong>,<br/>{{$order->sender_city}},<br />{{$order->pickup_country}}, <br />{{$vat_no}}</td>
                            </tr>
                        </table>
                        
                        <table cellpadding="0" cellspacing="0" style="width:100%; margin-top:50px;">
                            <tr>
                                <td style="padding:4px; background-color:#000;"></td>
                                <td colspan="5" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">INV- {{$str_invoice_no}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Invoice/Bill Date:</td>
                                <td style="padding:4px;">Due Date:</td>
                                <td colspan="2" style="padding:4px;">Service date:</td>
                                <td colspan="2" style="padding:4px;">Payment type:</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">{{date("d/m/Y")}}</td>
                                <td style="padding:4px;">{{date("d/m/Y")}}</td>
                                <td colspan="2" style="padding:4px;">{{$service_date}}</td>
                                <td colspan="2" style="padding:4px;">{{$payment_method}}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Description</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Quantity</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Unit Price</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Taxes</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Amount</td>
                            </tr>
                            <tr>
                            @if($invoice->invoice_type == 'Extra Charge')
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order {{$order->order_number}} – Additional charge ({{$extra->requester}})</td>
                            @else
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order {{$order->order_number}} – Shipping service. {{$order->pickup_country}} - {{$order->desti_country}}</td>
                            @endif
                                
                                <td style="padding:4px; background-color:#e7e7e7;">1.00</td>
                                <td style="padding:4px; background-color:#e7e7e7;">{{$invoice_amount - $vat_amount}} &euro;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">{{$vat}}</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:right;">{{$invoice_amount}} &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="4" style="padding:4px; border-bottom:1px solid #000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">Sub Total</td>
                                <td style="padding:4px; text-align:right;">{{$invoice_amount - $vat_amount}} &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">VAT {{$vat}} &euro;</td>
                                <td style="padding:4px; text-align:right;">{{$vat_amount}} &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; color:#fff;">&nbsp;</td>
                                <td colspan="3" style="background-color:#000; padding:4px; color:#fff;">Total</td>
                                <td style="padding:4px; background-color:#000; color:#fff;text-align:right;">{{$invoice->invoice_amount}} &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:60px 4px; text-align:center;">Payment reference: INV-{{$str_invoice_no}} / IBAN: RO80 INGB 0000 9999 1362 3897 (SWIFT/BIC: INGBROBU)</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:4px; text-align:center; background-color:#000; color:#6f7071;">www.easymoveeurope.com || +40 317 801 214 || info@easymoveeurope.com</td>
                            </tr>
                        </table>
                    
                    </div>
                </div>
            </div>
        </div>
</div>
