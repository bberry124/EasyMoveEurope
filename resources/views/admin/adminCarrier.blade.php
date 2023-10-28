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
        <div class="row d-flex justify-content-center">
            <div class="row dt-content mt-5">
                <div class="col-md-12 text-right mb-5 d-flex justify-content-between">
                    <h1 class="mt-0 fredoka">Carrier Management</h1>
                   <div>
                        <!-- <a class="btn btn-primary mt-3" href="adminNewUser" id="user_approve"><i class="fa fa-unlock-alt" aria-hidden="true"></i></a> -->
                        <a class="btn btn-success mt-3" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered data-table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>Location</th>
                                <th>Zip Code</th>
                                <th>City</th>
                                <th>VAT ID</th>
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
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="carrier_name" class="col-sm-6 control-label">User name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="carrier_name" name="carrier_name" placeholder="{{__("Enter User name")}}" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="carrier_email" class="col-sm-6 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" id="carrier_email" name="carrier_email" placeholder="{{__("Enter Email")}}" class="form-control" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="carrier_country" class="col-sm-6 control-label">Country</label>
                            <div class="col-sm-12">
                                <select id="countrys" name="company_country"
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
                            <label for="phone" class="col-sm-6 control-label">Phone</label>
                            <div class="col-sm-12">
                                <input type="text" id="phone" name="phone" placeholder="{{__("Enter Phone")}}" class="form-control" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location" class="col-sm-6 control-label">Street name, number</label>
                            <div class="col-sm-12">
                                <input type="text" id="location" name="location" placeholder="{{__("Enter Street name, number")}}" class="form-control" required="">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="zipcode" class="col-sm-6 control-label">Zip Code</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="zipcode" name="zipcode" placeholder="{{__("Enter Zip Code")}}" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="city" class="col-sm-6 control-label">City</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="city" name="city" placeholder="{{__("Enter City")}}" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label for="vat_name" class="col-sm-6 control-label">VAT ID</label>
                            <div class="col-sm-12">
                                <input type="text" id="vat_name" name="vat_name" placeholder="{{__("Enter VAT ID")}}" class="form-control">
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
                ajax: "{{ route('adminCarrier.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'carrier_name', name: 'carrier_name'},
                    {data: 'carrier_email', name: 'carrier_email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'company_country', name: 'company_country'},
                    {data: 'location', name: 'location'},
                    {data: 'zipcode', name: 'zipcode'},
                    {data: 'city', name: 'city'},
                    {data: 'vat_name', name: 'vat_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#createNewProduct').click(function () {

                $('#saveBtn').val("create-product");
                $('#id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Created New carrier");
                $('#ajaxModel').modal('show');
            });

$('body').on('click', '.editProduct', function () {

                var user_id = $(this).data('id');
                $.get("{{ route('adminCarrier.index') }}" +'/' + user_id +'/edit', function (data) {

                    $('#modelHeading').html("Edit User");
                    $('#saveBtn').val("edit-user");

                    $("#ajaxModel").on('show.bs.modal', function(){
                        $('#id').val(data.id);
                        $('#phone').val(data.phone);
                        $('#location').val(data.location);
                        $('#zipcode').val(data.zipcode);
                        $('#city').val(data.city);
                        $('#vat_name').val(data.vat_name);


                        $('#carrier_name').val(data.carrier_name);
                        $('#carrier_email').val(data.carrier_email);

                        $('#countrys').val(data.company_country);


                        getCountryCode($("#countrys").find('option:selected').attr('data-country'))

                    })
                    $('#ajaxModel').modal('show');





                })
            });

            
            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('adminCarrier.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                        table.draw();
                        $("#saveBtn").html('Submit');
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

            $('body').on('click', '.deleteProduct', function (){
                var user_id = $(this).data("id");
                var result = confirm("Are You sure want to delete !");
                if(result){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('adminCarrier.index') }}"+'/'+user_id,
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
    </script>
@endsection
