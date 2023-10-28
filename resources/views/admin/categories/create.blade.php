
@extends('layouts.adminApp')
@section('style')
    <link rel="stylesheet" href="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
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
                <h1>Add Category</h1>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Category Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="title">Category Status:</label>
                        <select class="form-control" name="status" required="">
                            <option value="">Select Status</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        @error('status')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-info">Create Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection


