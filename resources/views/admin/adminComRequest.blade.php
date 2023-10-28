@extends('layouts.adminApp')

@section('content')
        <div class="row d-flex justify-content-center">
            <div class="row dt-content mt-5">
                <div class="col-md-12 text-right mb-5 d-flex justify-content-between">
                    <h1 class="mt-0 fredoka">Company Request Management</h1>
                    <div>
                        <a class="btn btn-primary mt-3" href="{{url('admin/orders')}}" id="user_approve"><i class="fa fa-request" aria-hidden="true"></i> All Requests</a>
                        <a class="btn btn-primary mt-3" href="{{url("admin/adminRequest")}}" id="user_approve"><i class="fa fa-users" aria-hidden="true"></i> Person</a>
                        <a class="btn btn-success mt-3" href="{{url("admin/adminComRequest")}}" id="createNewProduct"><i class="fa fa-building" aria-hidden="true"></i> Company</a>
                        <a class="btn btn-secondary mt-3" href="{{url("admin/adminGuestRequest")}}" id="guestRequest"><i class="fa fa-user" aria-hidden="true"></i> Guest</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Pickup Date</th>
                                <th>Order Number</th>
                                <th>To pay</th>
                                <th>Client Type</th>
                                <th>Status</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    <script type="text/javascript">
        $(function () {

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('adminComRequest.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'collection_day', name: 'collection_day'},
                    {data: 'id', name: 'id'},
                    {data: 'price', name: 'price'},
                    {data: 'who_type', name: 'who_type'},
                    {data: 'status', name: 'status'},
                    {data: 'pickup_country', name: 'pickup_country'},
                    {data: 'desti_country', name: 'desti_country'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#createNewProduct').click(function () {
                $('#saveBtn').val("create-product");
                $('#repair_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editProduct', function () {
                var repair_id = $(this).data('id');
                $.get("{{ route('adminComRequest.index') }}" +'/' + repair_id +'/edit', function (data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#repair_id').val(data.id);
                    $('#reg_number').val(data.reg_number);
                    $('#email').val(data.email);
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('adminComRequest.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '.deleteProduct', function (){
                var repair_id = $(this).data("id");
                var result = confirm("Are You sure want to delete !");
                if(result){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('adminComRequest.store') }}"+'/'+repair_id,
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }else{
                    return false;
                }
            });
        });
    </script>
@endsection
