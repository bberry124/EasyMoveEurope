@extends("layouts.app")

@section("style")
  <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
  <style>
      .card {
          box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
          border-radius: 20px;
          overflow: hidden;
          margin-top: 50px;
      }
      .card-body {
          background-color: #fff;
          padding: 40px;
          text-align: center;
      }
      .card-title {
          font-size: 24px;
          margin-bottom: 20px;
          font-weight: bold;
          text-transform: uppercase;
      }
      .card-text {
          font-size: 14px;
          color: #333;
          margin-bottom: 20px;
          text-align: left;
      }
      .form-check {
          margin-top: 20px;
      }

      @media (max-width: 992px) {
          .card {
              margin-top: 20px;
          }
      }
      .form-check-label {
          font-size: 18px;
          font-weight: bold;
      }

  </style>
@endsection

@section("content")

    <div class="container">
    @if($defferd_allow == "No")
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 style="margin-bottom:5px;" class="card-title">{{__('Credit / Debit Card')}}</h5>
                        <p style="text-align:center;" class="card-text">{{__('Proceed Payment With Debit / Card.')}}</p>
                        <div class="form-check">
                            <input class="" type="radio" value="card" name="payment_type" id="defaultCheck1" onclick="selectPaymentMethod(1)">
                            <label class="form-check-label" for="defaultCheck1">
                                Select
                            </label>
                        </div>
                        <div>
                            <img src="/img/strype_payment.png" style="position:absolute; right:15px; bottom:7px; max-width:100px;" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 style="margin-bottom:5px;" class="card-title">{{__('Bank Transfer')}}</h5>
                        <p style="text-align:center;" class="card-text">Proceed Payment With {{__('Bank Transfer')}}.</p>
                        <div class="form-check">
                            <input class="" type="radio" value="bank" name="payment_type" id="defaultCheck2" onclick="selectPaymentMethod(2)" />
                            <label class="form-check-label" for="defaultCheck2">
                                Select
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif
@if($defferd_allow == "Yes")
      <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 style="margin-bottom:5px;" class="card-title">{{__('Credit / Debit Card')}}</h5>
                        <p style="text-align:center;" class="card-text">{{__('Proceed Payment With Debit / Card.')}}</p>
                        <div class="form-check">
                            <input class="" type="radio" value="card" name="payment_type" id="defaultCheck1" onclick="selectPaymentMethod(1)">
                            <label class="form-check-label" for="defaultCheck1">
                                Select
                            </label>
                        </div>
                        <div>
                            <img src="/img/strype_payment.png" style="position:absolute; right:15px; bottom:7px; max-width:100px;" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 style="margin-bottom:5px;" class="card-title">{{__('Bank Transfer')}}</h5>
                        <p style="text-align:center;" class="card-text">Proceed Payment With {{__('Bank Transfer')}}.</p>
                        <div class="form-check">
                            <input class="" type="radio" value="bank" name="payment_type" id="defaultCheck2" onclick="selectPaymentMethod(2)" />
                            <label class="form-check-label" for="defaultCheck2">
                                Select
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 style="margin-bottom:5px;" class="card-title">{{__('Deferred Payment')}}</h5>
                        <p style="text-align:center;" class="card-text">Proceed Payment With {{__('Deferred')}}.</p>
                        <div class="form-check">
                            <input class="" type="radio" value="defferd" name="payment_type" id="defaultCheck3" onclick="selectPaymentMethod(3)" />
                            <label class="form-check-label" for="defaultCheck3">
                                Select
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif
    </div>


    {{--<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
  <div class="panel panel-default">
    <div class="panel-heading d-flex justify-content-around">
      <div class="row text-center">
        <h3 class="panel-heading">{{__('Payment Details')}}</h3>any
      </div>
      <div class="display-td">
        <img class="img-responsive strip-img pull-right" src="{{ asset('img/custom/PngItem_2918799.png') }}">
      </div>
    </div>
    <div class="panel-body">

      @if (Session::has('success'))
      <div class="alert alert-success text-center">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">ta<i class="fa fa-info"
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
            <button class="btn btn-danger btn-lg btn-block" type="submit">Pay Now
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
@endsection
@section('scripts')




    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {


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

        });

        const stripe = Stripe("{{env('STRIPE_KEY')}}");



        function selectPaymentMethod(id){
            if(id == 1){

                $("#checkout_page").find('button').click();
                return false;
            }

            if(id == 2){
              window.location.href = '{{url('bank_payment/' . base64_encode($reqItems->first()->order_number))}}'
            }

            if(id == 3){
              window.location.href = '{{url('defferd_payment/' . base64_encode($reqItems->first()->order_number))}}'
            }

        }
    </script>


    <form action="{{route('stripe.payment')}}" id="checkout_page" method="post" style="display:none">
        <input type="hidden" value= "{{request()->get('price')}}" name="price">
        <input type="hidden" value="{{$reqItems->first()->order_number}}" name="order_number">
        <input type="hidden" value="{{$reqItems->first()->contact_email}}" name="email">

        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{config('stripe.stripe_key_live')}}"
            data-amount="{{base64_decode(request()->get('price')) * 100}}"

            data-name="Easy Move Europe"
            data-description="Payment"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-zip-code="false"
            data-currency="eur">
        </script>
    </form>



@endsection

