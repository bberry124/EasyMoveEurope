@extends('layouts.adminApp')

@section('content')
        <div class="row d-flex justify-content-center">
            <div class="row dt-content mt-5">
                <div class="col-md-12 text-right mb-5 d-flex justify-content-between">
                    <h1 class="mt-0 fredoka">Transport Cost Management</h1>
                </div>
            </div>
        </div>

        <form id="productForm" name="productForm" class="form-horizontal d-flex">
            <input type="hidden" name="cost_id" id="cost_id" value="1">
            <div class="form-group col-8">
                <label for="cost" class="col-sm-2 control-label">Cost (€)</label>
                <div class="col-sm-12">
                    <input type="number" class="form-control" id="cost" name="cost" placeholder="{{__("Enter the transport cost")}}" maxlength="10" required="">
                </div>
            </div>

            <div class="col-4" style="margin-top: 31px;">
                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
            </div>
        </form>

    <script type="text/javascript">
        $(function () {

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $costs = {{$cost}}
            $('#cost').val($costs);

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                var cost = $('#cost').val();
                var cost_id = $('#cost_id').val();

                $.ajax({
                    data: {cost:cost, cost_id:cost_id},
                    url: "{{ route('adminCost.store') }}",
                    type: "POST",
                    success: function (data) {
                        $data_text = data.statusText;
                        Command: toastr["success"]($data_text, "Success");
                    },
                    error: function (data) {
                        Command: toastr["error"]("Please input the transport cost");
                        console.log('Error:', data);s
                    }
                });

            });

        });
    </script>
@endsection
