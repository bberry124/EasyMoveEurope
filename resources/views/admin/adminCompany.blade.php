@extends('layouts.adminApp')
@section('style')
    <link rel="stylesheet" href="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="//cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <style>
        .iti {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="row dt-content mt-5">
            <div class="col-md-12 text-right mb-5 d-flex justify-content-between">
                <h1 class="mt-0 fredoka">Companies Management</h1>
                <div>
                    <!-- <a class="btn btn-primary mt-3" href="adminNewUser" id="user_approve"><i class="fa fa-unlock-alt" aria-hidden="true"></i></a> -->
                    <!-- <a class="btn btn-success mt-3" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-user-plus" aria-hidden="true"></i></a> -->
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-12">
                    <table id="tbtTable" class="table table-bordered table-striped data-table table-responsive" style="width:100%;">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>VAT ID</th>
                            <th>Shipment Area</th>
                            <th>Street name, number</th>
                            <th>Zip Code</th>
                            <th>City</th>
                            <th>Created At</th>
                            {{--                                <th></th>--}}
                            <!-- <th></th> -->
                            <!-- <th>Created_at</th> -->
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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
                        <input type="hidden" name="user_id" id="user_id">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">User name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="{{__('Enter User name')}}" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" id="email" name="email" placeholder="{{__('Enter Email')}}"
                                       class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Company Name</label>
                            <div class="col-sm-12">
                                <input type="text" id="contact_name" name="company_name"
                                       placeholder="{{__('Enter Company Name')}}" class="form-control" required="">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Country</label>
                            <div class="col-sm-12">
                                <select id="country" name="country"
                                        onchange="getCountryCode($(this).find('option:selected').attr('data-country'))"
                                        class="reg-text form-control @error('country') is-invalid @enderror" required>

                                    @foreach(allCountries(1) as $country_key => $country)

                                        <option data-country="{{$country_key}}"
                                                value="{{$loop->iteration > 1 ?  $country : $country_key}}">{{__($country)}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Phone</label>
                            <div class="col-sm-12">
                                <input type="number" id="phone" name="phone" placeholder="{{__('Enter Phone')}}"
                                       class="form-control" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">VAT ID:</label>
                            <div class="col-sm-12">
                                <input type="text" id="uvat" name="vat_name" placeholder="{{__('VAT ID')}}"
                                       class="form-control" required="">
                                       <input type="hidden" id="valid_vat" name="valid-vat">
                                <span class="pull-left" style="color:#1a1acf">{{__("VAT Validation Status")}}:</span>
                                <span class="pull-right" style="color:#1a1acf"><span class="valid_text">{{__("Valid VAT ID")}}</span> &nbsp;(<span class="update-valid-vat"> </span>)
                                                        <br>
                                                        <br>

                                                    <button type="button" onclick="verify_vat($('#uvat').val(), $('#user_id').val())" class="btn btn-primary btn-md">{{__("Verify in VIES")}}</button>
                                                    </span>

                            </div>
                        </div>
                        <br>
                        <br>

                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Shipment Area</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="shipment_area" name="ship_area">
                                    <option value="">Select Option</option>
                                    <option value="international">International</option>
                                    <option value="domestic">Domestic</option>

                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Street name, number</label>
                            <div class="col-sm-12">
                                <input type="text" id="location" name="location"
                                       placeholder="{{__('Street name, number')}}" class="form-control" required="">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email" class="col-sm-6 control-label">Zip Code</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="zipcode" name="zipcode"
                                               placeholder="{{__('Zip Code')}}" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email" class="col-sm-6 control-label">City</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="city" name="city"
                                               placeholder="{{__('City')}}" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="pwd">
                            <label for="password" class="col-sm-6 control-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" id="password" name="password"
                                       placeholder="{{__('Enter password')}}" class="form-control" required="">
                            </div>
                        </div>

                        <div class="form-group" id="con_pwd">
                            <label for="password" class="col-sm-6 control-label">Confirm Password</label>
                            <div class="col-sm-12">
                                <input type="password" id="confirm_password" name="confirm_password"
                                       placeholder="{{__('Enter password')}}" class="form-control" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(function () {


            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('adminCompany.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'contact_name'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'company_country', name: 'country'},
                    {data: 'vat_name', name: 'vat_name'},
                    /*{data: 'ship_count', name: 'ship_count'},*/
                    {data: 'ship_area', name: 'ship_area'},
                    {data: 'location', name: 'location'},
                    {data: 'zipcode', name: 'zipcode'},
                    {data: 'city', name: 'city'},
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
                var user_id = $(this).data('id');
                $.get("{{ route('adminCompany.index') }}" + '/' + user_id + '/edit', function (data) {

                    $('#modelHeading').html("Edit User");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $("#country").val(data.company_country);
                    $("#uvat").val(data.vat_name);
                    $("#valid_vat").val(data.valid_vat);
                    $("#shipment_area").val(data.ship_area);
                    $("#phone").val(data.phone);
                    $("#location").val(data.location);
                    $("#zipcode").val(data.zipcode);
                    $("#city").val(data.city);
                    $(".update-valid-vat").html(data.valid_vat_or_not ? '0%' : '19%');

                    $(".valid_text").text(data.valid_vat_or_not ? "{{"Valid VAT ID"}}" : "{{"Non-valid VAT"}}");

                    $("#contact_name").val(data.company_name)
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#pwd').hide();
                    $('#con_pwd').hide();

                    getCountryCode($("#country").find('option:selected').data('country'))
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('adminCompany.store') }}",
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
                        var errors = data.responseJSON.errors; // Retrieve errors from response
                        var error_text = '';

                        // Loop through errors and concatenate into a single string
                        $.each(errors, function (key, value) {
                            error_text += value + '<br>';
                        });
                        Command: toastr["error"](error_text, "Error");

                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '.deleteProduct', function () {
                var user_id = $(this).data("id");
                var result = confirm("Are You sure want to delete !");
                if (result) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('adminCompany.store') }}" + '/' + user_id,
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    return false;
                }
            });
        });

        function getCountryCode(value) {


            contact_phone = document.getElementById('phone')

            $(".iti__flag-container").remove();

            window.intlTelInput(contact_phone, {
                initialCountry: value,
                formatOnDisplay: true,
                separateDialCode: true,
                hiddenInput: "contact_full_phone",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                onlyCountries: ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk",
                    "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
                    "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
                    "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"],
            })
        }

        function verify_vat(value, user_id){

            $.post('{{route('admin.verify-vat')}}',{'user_id':user_id, 'vat': value, '_token' : '{{csrf_token()}}'}, function(data){

                if(data == true){
                    $(".update-valid-vat").text('0%');
                    $(".valid_text").text("{{"Valid VAT ID"}}")
                    Command: toastr["success"]("{{__("Valid Vat")}}", "Success");

                }
                else{
                    $(".update-valid-vat").text('19%');
                    $(".valid_text").text("{{"Non-valid VAT"}}")
                    Command: toastr["error"]("{{__("Invalid Vat")}}", "Error");
                }
            })
        }
    </script>
@endsection


