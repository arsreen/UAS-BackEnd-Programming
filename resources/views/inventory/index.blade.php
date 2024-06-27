@extends('layouts.app')

@section('content')
<style>
    .container-fluid {
        padding: 0 15px;
        margin-top: 50px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4><b>Inventory</b></h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th class="text-center">#</th>
                            <th class="text-center">Supply Name</th>
                            <th class="text-center">Stock Available</th>
                        </thead>
                        <tbody>
                        @foreach ($supplies as $i => $supply)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $supply->name }}</td>
                                <td class="text-right">{{ $supply->available }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Supply In/Out List
                    <button class="btn btn-primary btn-sm float-right" id="manage-supply">Manage Supply</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th class="text-center">Date</th>
                            <th class="text-center">Supply Name</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Type</th>
                            <th class="text-center"></th>
                        </thead>
                        <tbody id="inventory-table">
                        @foreach ($inventories as $inventory)
                            <tr>
                                <td class="text-center">{{ $inventory->created_at ? $inventory->created_at->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $supplyArr[$inventory->supply_id] }}</td>
                                <td class="text-right">{{ $inventory->qty }}</td>
                                <td class="text-center">
                                    @if($inventory->stock_type == 1)
                                        <span class="badge badge-primary"> IN </span>
                                    @else
                                        <span class="badge badge-secondary"> Used </span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary edit_stock" data-id="{{ $inventory->id }}"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete_stock" data-id="{{ $inventory->id }}"><i class="fa fa-trash"></i></button>
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

<div class="modal fade" id="manageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="manage-inv" action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Manage Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="inventory_id">
                    <div class="form-group">
                        <label for="supply_id" class="control-label">Supply Name</label>
                        <select class="custom-select browser-default" name="supply_id" id="supply_id">
                            @foreach($supplies as $supply)
                            <option value="{{ $supply->id }}">{{ $supply->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty" class="control-label">QTY</label>
                        <input type="number" step="any" min="1" class="form-control text-right" name="qty" id="qty">
                    </div>
                    <div class="form-group">
                        <label for="stock_type" class="control-label">Type</label>
                        <select name="stock_type" id="stock_type" class="custom-select browser-default">
                            <option value="1">Stock In</option>
                            <option value="2">Use</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $('table').dataTable();
    $('#manage-supply').click(function(){
        $('#manageModal').modal('show');
    });

    $('#manage-inv').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if(resp.status == 1){
                    alert_toast(resp.message, 'success');
                    $('#manageModal').modal('hide');
                    refreshTable();
                }
            }
        });
    });

    $('.edit_stock').click(function(){
        var id = $(this).data('id');
        $.ajax({
            url: '/inventory/' + id + '/edit',
            method: 'GET',
            success: function(data) {
                $('#inventory_id').val(data.id);
                $('#supply_id').val(data.supply_id);
                $('#qty').val(data.qty);
                $('#stock_type').val(data.stock_type);
                $('#manageModal').modal('show');
            }
        });
    });

    $('.delete_stock').click(function(){
        if (confirm("Are you sure to remove this data from list?")) {
            var id = $(this).data('id');
            $.ajax({
                url: '/inventory/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'DELETE',
                success: function(resp) {
                    if (resp.status == 1) {
                        alert_toast(resp.message, 'success');
                        refreshTable();
                    }
                }
            });
        }
    });

    function refreshTable() {
        $.ajax({
            url: '{{ route("inventory.index") }}',
            success: function(data) {
                var tableContent = $(data).find('#inventory-table').html();
                $('#inventory-table').html(tableContent);
                attachEventHandlers();
            }
        });
    }

    function attachEventHandlers() {
        $('.edit_stock').click(function(){
            var id = $(this).data('id');
            $.ajax({
                url: '/inventory/' + id + '/edit',
                method: 'GET',
                success: function(data) {
                    $('#inventory_id').val(data.id);
                    $('#supply_id').val(data.supply_id);
                    $('#qty').val(data.qty);
                    $('#stock_type').val(data.stock_type);
                    $('#manageModal').modal('show');
                }
            });
        });

        $('.delete_stock').click(function(){
            if (confirm("Are you sure to remove this data from list?")) {
                var id = $(this).data('id');
                $.ajax({
                    url: '/inventory/' + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'DELETE',
                    success: function(resp) {
                        if (resp.status == 1) {
                            alert_toast(resp.message, 'success');
                            refreshTable();
                        }
                    }
                });
            }
        });
    }

    attachEventHandlers();

    function alert_toast(message, type) {
        var toast = $('<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">' +
            '<div class="toast-header">' +
            '<strong class="mr-auto">' + type.toUpperCase() + '</strong>' +
            '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>' +
            '<div class="toast-body">' + message + '</div>' +
            '</div>');

        $('#alert-container').append(toast);
        toast.toast({ delay: 3000 });
        toast.toast('show');
    }
</script>
@endsection
@endsection
