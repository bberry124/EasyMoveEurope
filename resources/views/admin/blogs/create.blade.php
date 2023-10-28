
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
                    <h1>Add Blog</h1>
                    <form action="{{ route('admin.blogs.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="error">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" name="cat_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('cat_id')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="8" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Publish</label>
                            <select class="form-control" name="status">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            @error('status')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div><br>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" required>
                            @error('image')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="header_description">Meta Description</label>
                            <input type="text" name="header_description" id="header_description" class="form-control" value="{{ old('header_description') }}" required>
                            @error('header_description')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="header_tags">Meta Keywords</label>
                            <input type="text" name="header_tags" id="header_tags" class="form-control" value="{{ old('header_tags') }}" required>
                            @error('header_tags')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Create</button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            CKEDITOR.replace( 'description' );
        </script>
@endsection


