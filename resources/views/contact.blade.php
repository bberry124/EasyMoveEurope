@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section("content")
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('{{ asset('img/EasyMove/contact us.jpg') }}');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2 class="mt-5">{{__('Contact us')}}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Breadcrumbs -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">
        <div>
          <iframe style="border:0; width: 100%; height: 340px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2846.58855129289!2d26.091444115746306!3d44.48260590641934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b202666fea7c3d%3A0x12dd4b4cc025ce80!2sStrada%20Feleacu%203%2C%20Bucure%C8%99ti%20077190%2C%20Romania!5e0!3m2!1sen!2sin!4v1679739828670!5m2!1sen!2sin" frameborder="0" allowfullscreen></iframe>
        </div><!-- End Google Maps -->
        <div class="row gy-4 mt-4">
          <div class="col-lg-4">
            <div class="info-item d-flex">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div style="text-align: left;">
                <h4>{{__('Location:')}}</h4>
                <p>{{__('Strada Feleacu 3, 077190 Bucharest, Romania')}}</p>
              </div>
            </div><!-- End Info Item -->
            <div class="info-item d-flex" style="text-align: left;">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h4>{{__('Email:')}}</h4>
                <p>info@easymoveeurope.com</p>
              </div>
            </div><!-- End Info Item -->
            <div class="info-item d-flex" style="text-align: left;">
              <i class="bi bi-phone flex-shrink-0"></i>
              <div>
                <h4>{{__('Call:')}}</h4>
                <p>+40 317 801 214</p>
              </div>
            </div><!-- End Info Item -->
          </div>
          <div class="col-lg-8">
            <form action="{{url('contact_us')}}" method="post" role="form" class="php-email-form">
                {{csrf_field()}}
              <div class="row">
                @if(session('success'))
                  <div class="my-3">
                    <div class="form-group mt-4 mb-4">
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    </div>
                  </div>
                @endif
                @if($errors->any())
                  <div class="my-3">
                    <div class="form-group mt-4 mb-4">
                      <div class="alert alert-danger">
                        <ul>
                          @foreach ($errors->all() as $error)
                            <li>{{__("$error")}}</li>
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"  value="{{ old('name') }}"  required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email"  value="{{ old('email') }}"  class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control"  value="{{ old('subject') }}"  name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required>{{ old('message') }}</textarea>
              </div>
              <div class="my-3">
                <div class="form-group mt-4 mb-4">
                  {!! captcha_image_html('ContactCaptcha') !!}
                </div>
              </div><br>
              <div class="my-3">
                <div class="form-group mb-4">
                  <input class="form-control" type="text" id="CaptchaCode" name="CaptchaCode">
                </div>
              </div>
              <div class="text-center"><button type="submit" class="sendbtn">{{__('Send Message')}}</button></div>
            </form>
          </div><!-- End Contact Form -->
        </div>
      </div>
    </section>
    <!-- End Contact Section -->
</main>
<!-- End #main -->
@endsection
