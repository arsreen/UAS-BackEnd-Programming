@extends('layouts.app')

@section('content')
<style>
    .container-fluid {
        padding: 0 15px;
        margin-top: 50px;
    }
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button class="col-sm-3 float-right btn btn-primary btn-sm" type="button" id="new_laundry"><i class="fa fa-plus"></i> New Laundry</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="laundry-list">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Queue</th>
                                    <th class="text-center">Customer Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laundryList as $laundry)
                                <tr>
                                    <td class="">{{ date('M d, Y', strtotime($laundry->date_created)) }}</td>
                                    <td class="text-right">{{ $laundry->queue }}</td>
                                    <td class="">{{ ucwords($laundry->customer_name) }}</td>
                                    <td class="text-center">
                                        @if ($laundry->status == 0)
                                        <span class="badge badge-secondary">Pending</span>
                                        @elseif ($laundry->status == 1)
                                        <span class="badge badge-primary">Processing</span>
                                        @elseif ($laundry->status == 2)
                                        <span class="badge badge-info">Ready to be Claimed</span>
                                        @elseif ($laundry->status == 3)
                                        <span class="badge badge-success">Claimed</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm edit_laundry" data-id="{{ $laundry->id }}">Edit</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm delete_laundry" data-id="{{ $laundry->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#new_laundry').click(function(){
            window.location.href = '{{ route("laundry.create") }}';
        })
        $('.edit_laundry').click(function(){
            window.location.href = '{{ url("laundry") }}/' + $(this).attr('data-id') + '/edit';
        })
        $('.delete_laundry').click(function(){
            if (confirm("Are you sure to remove this data from list?")) {
                delete_laundry($(this).attr('data-id'));
            }
        })
        $('#laundry-list').dataTable()

        function delete_laundry(id){
            start_load()
            $.ajax({
                url: '{{ url("laundry") }}/' + id,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if (resp.status == 1) {
                        alert_toast("Data successfully deleted", 'success')
                        setTimeout(function(){
                            location.reload()
                        }, 1500)
                    }
                }
            })
        }
    });
</script>
@endsection
