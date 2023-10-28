@extends("layouts.app")

@section("style")
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script
@endsection

@section("content")                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               </header>
    <section class="container dashboard">
        <div class="dashboard-area">

            @include("partials.companySidebar")

            <div class="db-content col-lg-9 col-md-7 col-sm-12 col-12">
                <div class="db-top">
                    <h3 class="fredoka">
                        {{__('Upcoming Service')}}
                    </h3>
                    <div class="pull-right">
                        <a href="{{url('company/companyQuote/create')}}" class="btn btn-primary btn-md">{{__('New Order')}}</a>
                    </div>
                </div>
                <div class="db-field">
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table class="table table-hover data-tablea table-striped table-bordered"">
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

                      </table>
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


            var table = $('.data-tablea').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('company/companyQuote') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'collection_day', name: 'collection_day'},
                    {data: 'id', name: 'id'},
                    {data: 'price', name: 'price'},

                    {data: 'status', name: 'status'},
                    {data: 'pickup_country', name: 'pickup_country'},
                    {data: 'desti_country', name: 'desti_country'},
                    {data: 'view', searchable:false, orderable:false}
                ]
            });
        })
    </script>
@endsection
