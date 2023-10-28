@extends('layouts.adminApp')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="row dt-content mt-5">
            <div class="col-md-12 text-right mb-5 d-flex justify-content-between">
                <h1 class="mt-0 fredoka">All Orders</h1>
                <div>
                    <a class="btn btn-primary mt-3" href="{{url('admin/orders')}}" id="user_approve"><i class="fa fa-request" aria-hidden="true"></i> All Requests</a>
                    <a class="btn btn-primary mt-3" href="{{url('admin/adminRequest')}}" id="user_approve"><i class="fa fa-users" aria-hidden="true"></i> Person</a>
                    <a class="btn btn-success mt-3" href="{{url('admin/adminComRequest')}}" id="createNewProduct"><i class="fa fa-building" aria-hidden="true"></i> Company</a>
                    <a class="btn btn-secondary mt-3" href="{{url('admin/adminGuestRequest')}}" id="guestRequest"><i class="fa fa-user" aria-hidden="true"></i> Guest</a>
                </div>
            </div>

            <div class="col-md-12">
                <table class="table table-bordered data-tablea">
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">



                    {{--<form id="productForm" method="post" action="" name="productForm" class="form-horizontal">
                        {{csrf_field()}}
                        @method('PUT')
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Status</label>
                            <div class="col-sm-12">
                                {!! Form::select('status', array_merge(["" => 'Select Option'], \App\Models\Price::$status), null, ['class' => 'form-control', 'id' => 'select_status']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Pickup Date</label>
                            <div class="col-sm-12">
                                <input type="date" id="pickup_date" name="collection_day" placeholder="{{__("Enter Email")}}" class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="col-sm-12">
                            <select id="pickup_country" name="pickup_country" class="form-control select-country country-input" required>
                                <option value="">{{langChange("Type to search", session('locale'))}}</option>
                                <option value="AT">{{langChange("Austria", session('locale'))}}</option>
                                <option value="BE">{{langChange("Belgium", session('locale'))}}</option>
                                <option value="BG">{{langChange("Bulgaria", session('locale'))}}</option>
                                <option value="HR">{{langChange("Croatia", session('locale'))}}</option>
                                <option value="CZ">{{langChange("Czech Republic", session('locale'))}}</option>
                                <option value="DK">{{langChange("Denmark", session('locale'))}}</option>
                                <option value="EE">{{langChange("Estonia", session('locale'))}}</option>
                                <option value="FI">{{langChange("Finland", session('locale'))}}</option>
                                <option value="FR">{{langChange("France", session('locale'))}}</option>
                                <option value="DE">{{langChange("Germany", session('locale'))}}</option>
                                <option value="GR">{{langChange("Greece", session('locale'))}}</option>
                                <option value="HU">{{langChange("Hungary", session('locale'))}}</option>
                                <option value="IE">{{langChange("Ireland", session('locale'))}}</option>
                                <option value="IT">{{langChange("Italy", session('locale'))}}</option>
                                <option value="LV">{{langChange("Latvia", session('locale'))}}</option>
                                <option value="LT">{{langChange("Lithuania", session('locale'))}}</option>
                                <option value="LU">{{langChange("Luxembourg", session('locale'))}}</option>
                                <option value="NL">{{langChange("Netherlands", session('locale'))}}</option>
                                <option value="NO">{{langChange("Norway", session('locale'))}}</option>
                                <option value="PL">{{langChange("Poland", session('locale'))}}</option>
                                <option value="PT">{{langChange("Portugal", session('locale'))}}</option>
                                <option value="RO">{{langChange("Romania", session('locale'))}}</option>
                                <option value="RS">{{langChange("Serbia", session('locale'))}}</option>
                                <option value="SK">{{langChange("Slovakia", session('locale'))}}</option>
                                <option value="SI">{{langChange("Slovenia", session('locale'))}}</option>
                                <option value="ES">{{langChange("Spain", session('locale'))}}</option>
                                <option value="SE">{{langChange("Sweden", session('locale'))}}</option>
                                <option value="CH">{{langChange("Switzerland", session('locale'))}}</option>
                                <option value="GB">{{langChange("United Kingdom", session('locale'))}}</option>
                            </select>
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                        <select id="destination_country" name="destination_country" class="form-control select-country country-input" required>
                            <option value="">{{langChange("Type to search", session('locale'))}}</option>
                            <option value="AT">{{langChange("Austria", session('locale'))}}</option>
                            <option value="BE">{{langChange("Belgium", session('locale'))}}</option>
                            <option value="BG">{{langChange("Bulgaria", session('locale'))}}</option>
                            <option value="HR">{{langChange("Croatia", session('locale'))}}</option>
                            <option value="CZ">{{langChange("Czech Republic", session('locale'))}}</option>
                            <option value="DK">{{langChange("Denmark", session('locale'))}}</option>
                            <option value="EE">{{langChange("Estonia", session('locale'))}}</option>
                            <option value="FI">{{langChange("Finland", session('locale'))}}</option>
                            <option value="FR">{{langChange("France", session('locale'))}}</option>
                            <option value="DE">{{langChange("Germany", session('locale'))}}</option>
                            <option value="GR">{{langChange("Greece", session('locale'))}}</option>
                            <option value="HU">{{langChange("Hungary", session('locale'))}}</option>
                            <option value="IE">{{langChange("Ireland", session('locale'))}}</option>
                            <option value="IT">{{langChange("Italy", session('locale'))}}</option>
                            <option value="LV">{{langChange("Latvia", session('locale'))}}</option>
                            <option value="LT">{{langChange("Lithuania", session('locale'))}}</option>
                            <option value="LU">{{langChange("Luxembourg", session('locale'))}}</option>
                            <option value="NL">{{langChange("Netherlands", session('locale'))}}</option>
                            <option value="NO">{{langChange("Norway", session('locale'))}}</option>
                            <option value="PL">{{langChange("Poland", session('locale'))}}</option>
                            <option value="PT">{{langChange("Portugal", session('locale'))}}</option>
                            <option value="RO">{{langChange("Romania", session('locale'))}}</option>
                            <option value="RS">{{langChange("Serbia", session('locale'))}}</option>
                            <option value="SK">{{langChange("Slovakia", session('locale'))}}</option>
                            <option value="SI">{{langChange("Slovenia", session('locale'))}}</option>
                            <option value="ES">{{langChange("Spain", session('locale'))}}</option>
                            <option value="SE">{{langChange("Sweden", session('locale'))}}</option>
                            <option value="CH">{{langChange("Switzerland", session('locale'))}}</option>
                            <option value="GB">{{langChange("United Kingdom", session('locale'))}}</option>
                        </select>
                </div>
            </div>

                        --}}{{--<div class="form-group" id="pwd">
                            <label for="password" class="col-sm-6 control-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" id="password" name="password" placeholder="{{__("Enter password")}}" class="form-control" required="">
                            </div>
                        </div>

                        <div class="form-group" id="con_pwd">
                            <label for="password" class="col-sm-6 control-label">Confirm Password</label>
                            <div class="col-sm-12">
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="{{__("Enter password")}}" class="form-control" required="">
                            </div>
                        </div>--}}{{--

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        </div>
                    </form>--}}
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

            var table = $('.data-tablea').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('admin/orders') }}",
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
                return true;
                var repair_id = $(this).data('id');
                $.get("{{ route('adminRequest.index') }}" +'/' + repair_id +'/edit', function (data) {
                    $("#ajaxModel").find(".modal-body").html(data.view)
                    $('#modelHeading').html("Edit Order");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $("#pickup_country").val(data.pickup_country)
                    $("#destination_country").val(data.desti_country)
                    $("#productForm").attr('action', "{{url('admin/orders')}}" + "/" + repair_id)
                    $("#productForm").submit(function(e){

                        e.preventDefault()
                        data  = $(this).serialize();
                        $.post($(this).attr('action'), data, function(data){

                            if(data.status==2){
                                Command: toastr["success"]("{{__("Updated the profile")}}", "Success");
                                $('#ajaxModel').modal('hide');
                                table.ajax.reload();
                            }
                        })
                    })

                    $("#select_status").val(data.status === "" || data.status === null ? 'WAITING PAYMENT' : data.status)
                    $("#pickup_date").val(data.collection_day)

                })
            });

            $('body').on('click', '.deleteProduct', function (){
                var repair_id = $(this).data("id");
                var result = confirm("Are You sure want to delete !");
                if(result){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('adminRequest.store') }}"+'/'+repair_id,
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
