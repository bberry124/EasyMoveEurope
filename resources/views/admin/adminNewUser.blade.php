@extends('layouts.adminApp')
  
@section('content')
        <div class="row d-flex justify-content-center">
            <div class="row dt-content mt-5">
                <div class="col-md-12 text-right mb-5 d-flex justify-content-between">
                    <h1 class="mt-0 fredoka">New Users Management</h1>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered data-table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name<th>
                                <!-- <th>Email</th> -->
                                <th>Created_at</th>
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
                ajax: "{{ route('adminNewUser.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#createNewProduct').click(function () {
                $('#saveBtn').val("create-product");
                $('#user_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New User");
                $('#ajaxModel').modal('show');
            });
            
            $('body').on('click', '.editProduct', function () {
                var user_id = $(this).data("id");
                var result = confirm("Are You sure want to approve !");
                if(result){
                    $.ajax({
                        type: "GET",
                        url: "{{ route('adminNewUser.store') }}"+'/'+user_id +'/edit',
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
            
            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
            
                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('adminUser.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        table.draw();
                    },
                    error: function (data) {
                        $error_text = data.statusText;
                        // Command: toastr["error"]($error_text, "Error");
                        Command: toastr["error"]("Please input all the fields exactly!");
                        console.log('Error:', data.statusText);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '.deleteProduct', function (){
                var user_id = $(this).data("id");
                var result = confirm("Are You sure want to delete !");
                if(result){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('adminUser.store') }}"+'/'+user_id,
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