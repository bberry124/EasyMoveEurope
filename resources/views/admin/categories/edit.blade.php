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
            <h1>Edit Category</h1>
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status">
                        <option value="0" {{ 0 == $category->status ? 'selected' : '' }}>No</option>
                        <option value="1" {{ 1 == $category->status ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('status')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div><br>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'description' );
</script>
@endsection

