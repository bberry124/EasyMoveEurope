@extends('layouts.adminApp')
@section('style')
    <link rel="stylesheet" href="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"/>
    <script src="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <style>
        .iti {
            width: 100%;
        }
        .relative{display:none;}
    </style>
@endsection

@section('content')
<div class="row d-flex justify-content-center">
    <div class="row dt-content mt-5">
        <div class="col-md-12 text-right mb-5 d-flex justify-content-between">
            <h1>Categories</h1>
           <div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create New Category</a>
            </div>
        </div>
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="col-md-12">
            <table class="table table-bordered data-table" id="example" style="width:100%;">
               <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $cat->status ? 'Yes' : 'No' }}</td>
                            <td>{{ $cat->created_at }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.categories.destroy', ['id' => $cat->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
             {{ $categories->links() }}
            </table>
        </div>
    </div>
</div>
<script>
    new DataTable('#example');
</script>
@endsection

