@extends('layouts.adminApp')

@section('content')
        <div class="row d-flex justify-content-center">
            <div class="row dt-content mt-5">
                <div class="col-md-12 text-right mb-5 d-flex justify-content-between">
                    <h1 class="mt-0 fredoka">Service Management</h1>
                    <a class="btn btn-success mt-3" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Service</th>
                                <th>Detail</th>
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal">
                        <input type="hidden" name="service_id" id="service_id">
                        <div class="form-group">
                            <label for="service" class="col-sm-2 control-label">Service</label>
                            <div class="col-sm-12">
                                <!-- <input type="text" class="form-control" id="service" name="service" placeholder="{{__("Enter a service")}}" value="" maxlength="50" required=""> -->
                                <select class="form-control rep-in form-select" id="service" name="service" aria-label="Service">
                                    <option class="rep-option d-none" selected disabled>Service *</option>
                                    <option class="rep-option" value="Timing Belts & Chains">Timing Belts & Chains</option>
                                    <option class="rep-option" value="Brakes">Brakes</option>
                                    <option class="rep-option" value="Clutch & Transmission">Clutch & Transmission</option>
                                    <option class="rep-option" value="Engine Management Light">Engine Management Light</option>
                                    <option class="rep-option" value="Suspension">Suspension</option>
                                    <option class="rep-option" value="Engine, Fuel & Turbo">Engine, Fuel & Turbo</option>
                                    <option class="rep-option" value="Steering">Steering</option>
                                    <option class="rep-option" value="General Diagnostics">General Diagnostics</option>
                                    <option class="rep-option" value="Electrical & Ignition">Electrical & Ignition</option>
                                    <option class="rep-option" value="Heating">Heating</option>
                                    <option class="rep-option" value="Cooling">Cooling</option>
                                    <option class="rep-option" value="Exhaust">Exhaust</option>
                                    <option class="rep-option" value="A/C Diagnosis">A/C Diagnosis</option>
                                    <option class="rep-option" value="Wipers">Wipers</option>
                                    <option class="rep-option" value="Windscreens">Windscreens</option>
                                    <option class="rep-option" value="Bodywork">Bodywork</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="detail" class="col-sm-2 control-label">Detail</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="detail" name="detail" placeholder="{{__("Enter a detail")}}" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                        </div>
                    </form>
                </div>
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
                ajax: "{{ route('adminService.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'service', name: 'service'},
                    {data: 'detail', name: 'detail'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#createNewProduct').click(function () {
                $('#saveBtn').val("create-product");
                $('#service_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editProduct', function () {
                var service_id = $(this).data('id');
                $.get("{{ route('adminService.index') }}" +'/' + service_id +'/edit', function (data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#service_id').val(data.id);
                    $('#service').val(data.service);
                    $('#detail').val(data.detail);
                    $('#email').val(data.email);
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();

                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('adminService.store') }}",
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
                        Command: toastr["error"]("Please input all the fields exactly!");
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '.deleteProduct', function (){
                var service_id = $(this).data("id");
                var result = confirm("Are You sure want to delete !");
                if(result){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('adminService.store') }}"+'/'+service_id,
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
