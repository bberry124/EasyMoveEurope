@extends("layouts.app")

@section("style")
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        .reg-btn {
            color: #fff;
            border: 3px solid #253247;
            background-image: linear-gradient(30deg, #253247 50%, transparent 50%);
            background-size: 500px;
            background-repeat: no-repeat;
            background-position: 0%;
            transition: background 500ms ease-in-out;
            width: 150px;
            height: 50px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: unset;
            width: 200px;
            margin: 20px auto;
        }
        .reg-btn:hover {
            background-position: 100%;
            color: #253247;
        }
        .reg-btn:active {
            color: #fff;
            border: 3px solid #253247;
            background-image: linear-gradient(30deg, #253247 50%, transparent 50%);
            background-size: 500px;
        }
        .reg-btn:focus {
            color: #fff;
            border: 3px solid #253247;
            background-image: linear-gradient(30deg, #253247 50%, transparent 50%);
            background-size: 500px;
        }
    </style>
@endsection

@section("content")
    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="page-header d-flex align-items-center" style="background-image: url('{{ asset('img/EasyMove/about us 1.jpg') }}');">
                <div class="container position-relative">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h2 class="mt-5">{{__('Verify Email Address')}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->

        <!-- ======= {{__('Verify Email Address')}} Section ======= -->
        <section id="about" class="about pt-5">
            <div class="container" data-aos="fade-up">

                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{__("Mail Sent Successfully.")}}
                    </div>
                    @endif
                <div class="row gy-4">
                    <div class="content order-last  order-lg-first">
                        <div class="container" data-aos="fade-up">
                            <h2 class="about-title">{{__('Verify Email Address')}}</h2>
                            <p class="about-text">
                                <form method="post" action="{{route('verification.send')}}">
                                @csrf
                                <button class="btn reg-btn btn-lg">{{__('Resend Email')}}</button>
                            </form>
                                </p>


                        </div>
                    </div>
                </div>

            </div>
        </section>



    </main>
    <!-- End #main -->
@endsection
