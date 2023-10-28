@extends('layouts.adminApp')
@section('style')
    <link rel="stylesheet" href="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
    <style>
        .iti {
            width: 100%;
        }
        .error{color:red;}
    </style>
@endsection

@section('content')
<div class="row d-flex justify-content-center">
    <div class="row dt-content mt-5">
        <div class="col-md-12">
            <h1>Edit Blog</h1>
            <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $blog->title }}" required>
                    @error('title')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="cat_id">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $blog->cat_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('cat_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="8" required>{{ $blog->description }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">Publish</label>
                    <select class="form-control" name="status">
                        <option value="0" {{ 0 == $blog->status ? 'selected' : '' }}>No</option>
                        <option value="1" {{ 1 == $blog->status ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('status')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div><br>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image">
                    @error('image')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">Uploaded Image</label><br>
                    <img src="{{ asset('storage/'.$blog->image) }}" style="max-width:700px;max-height: 250px;">
                </div>
                <div class="form-group">
                    <label for="header_description">Meta Description</label>
                    <input type="text" name="header_description" id="header_description" class="form-control" value="{{ $blog->header_description }}" required>
                    @error('header_description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="header_tags">Meta Keywords</label>
                    <input type="text" name="header_tags" id="header_tags" class="form-control" value="{{ $blog->header_tags }}" required>
                    @error('header_tags')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'description' );
</script>
@endsection

