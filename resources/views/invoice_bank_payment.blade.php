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
        <div class="row">

            {!!  sendInvoiceMailContent(request()->segment(2)) !!}


        </div>
    </div>

@endsection
