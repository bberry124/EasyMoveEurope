@extends("layouts.app")

@section("style")
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    @endsection

    @section("content")                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               </header>
    <section class="container dashboard">
        <div class="dashboard-area">

            @include("partials.sidebar")

            <div class="db-content col-lg-9 col-md-7 col-sm-12 col-12">
                <div class="db-top">
                    <h3 class="fredoka">
                        Your Orders
                    </h3>
                    <div class="pull-right">
                        <a href="{{route('user.create_order')}}" class="btn btn-primary btn-md">{{__('New Order')}}</a>
                    </div>
                </div>
                <div class="db-field">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-hover data-tablea table-striped table-bordered">
                                    <thead class="table-title">
                                    <tr class="quote-tr">
                                        <th>{{__('No')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th> {{__('Pickup Date')}}</th>
                                        <th>{{__('Order Number')}}</th>
                                        <th>{{__('To pay')}}</th>

                                        <th>{{__('Status')}}</th>
                                        <th>{{__('From')}}</th>
                                        <th>{{__('To')}}</th>
                                        <th>{{__('View')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-tablea').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('pastQuote') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'collection_day', name: 'collection_day'},
                    {data: 'id', name: 'id'},
                    {data: 'price', name: 'price'},

                    {data: 'status', name: 'status'},
                    {data: 'pickup_country', name: 'pickup_country'},
                    {data: 'desti_country', name: 'desti_country'},
                    {data: 'view', orderable: false, searchable:false},
                ]
            });
        })
    </script>
@endsection
