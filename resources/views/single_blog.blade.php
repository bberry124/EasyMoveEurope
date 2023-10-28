@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
<style>
 .bbtn{
    background: #36537E;
    padding: 10px;
    1px: ;
    border-radius: 5px;
    border-radius: 5;
    color: #fff;
    margin-top:10px;
}
.bbtn:hover{
    color:#fff;
}
</style>
@endsection

<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('{{ asset('img/EasyMove/about us 1.jpg') }}');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2 class="mt-5">Blog Post</h2>
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
                <div class="col-md-12 col-12">
                    <!-- Blog Post 1 -->
                    @section('content')
                    <div class="container" data-aos="fade-up">
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <div class="card mb-4 blog-li" style="border:none;">
                                    <h4 style="margin: 20px;text-align: left;">{{ $blog->title }}</h4>
                                    <p class="card-text" style="margin: 20px;text-align: left;">Date: {{ $blog->created_at }}  - {{ $categoryName }}</p>
                                    <p class="card-text" style="margin: 20px;text-align: left;"><img src="{{ asset('storage/'.$blog->image) }}" style="width:100%;max-height: 400px;"></p>
                                    <div class="card-body" style="text-align:left;">
                                        <p class="card-text">{!! $blog->description !!}</p>
                                    </div>
                                    <div class="row justify-content-center mt-4">
                                        <div class="col-lg-4 col-md-6 col-6 text-center">
                                            @if ($previousBlog)
                                                <a href="{{ route('single_blog', ['slug' => $previousBlog->slug]) }}" class="btn btn-primary">&lt; Previous</a>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-6 text-center">
                                            @if ($nextBlog)
                                                <a href="{{ route('single_blog', ['slug' => $nextBlog->slug]) }}" class="btn btn-primary">Next &gt;</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    @endsection
                </div>
            </div>
        </div>
    </section><!-- End Stats Counter Section -->
</main>
<!-- End #main -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
$(document).ready(function() {
    // Loop through each paragraph in the "content" div
    $('.card-body p').each(function() {
      // Find the last hyperlink within this paragraph
      var lastLink = $(this).find('a:last');

      // Add the class "btn btn-info" to the last hyperlink
      lastLink.addClass('bbtn');
    });
  });
</script> -->