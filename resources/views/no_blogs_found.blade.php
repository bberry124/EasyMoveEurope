@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section("content")
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('{{ asset('img/EasyMove/about us 1.jpg') }}');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2 class="mt-5">{{__('No Blog Found')}}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Breadcrumbs -->
    <style>
        .blog-li{border:none;}
        body{text-align:left;}
        .card-body{padding-top:0px;}
        a{text-decoration:none;color:#000;}
        a:hover{color:#000;}
    </style>
    <!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="about pt-5" >
        <div class="container" data-aos="fade-up">
            <div class="row">
                <!-- Main Content (Blog Listing) -->
                <div class="col-md-8">
                   <p>No blog found....</p>
                </div>
                <!-- Side Categories -->
                <div class="col-md-4">
                    <h4>Categories</h4>
                    <ul class="list-group">
                        @foreach ($categories as $category)
                        <a style="margin-bottom: 5px;" href="{{ url('cat-blogs', ['id' => $category->id]) }}"><li class="list-group-item">{{ $category->name }}</li></a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section><!-- End Stats Counter Section -->

</main>
<!-- End #main -->
@endsection
