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
        <!-- FORM Panel -->
        <div class="col-md-4">
            <form id="manage-supply">
                @csrf
                <div class="card">
                    <div class="card-header">
                        Laundry Supply Form
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label class="control-label">Supply</label>
                            <textarea name="name" id="" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-supply').get(0).reset()"> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- FORM Panel -->

        <!-- Table Panel -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="supply-table">
                            @foreach($supplies as $i => $supply)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>
                                    <p><b>{{ $supply->name }}</b></p>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary edit_supply" type="button" data-id="{{ $supply->id }}" data-name="{{ $supply->name }}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete_supply" type="button" data-id="{{ $supply->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Table Panel -->
    </div>
</div>

<style>
    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset;
    }
</style>

@section('scripts')
<script>
    $('#manage-supply').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/supplies',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(resp) {
                if (resp.status == 1) {
                    alert_toast(resp.message, 'success');
                } else if (resp.status == 2) {
                    alert_toast(resp.message, 'success');
                }
                refreshTable();
                $('#manage-supply').get(0).reset();
            }
        });
    });

    $('.edit_supply').click(function() {
        var supply = $('#manage-supply');
        supply.get(0).reset();
        supply.find("[name='id']").val($(this).attr('data-id'));
        supply.find("[name='name']").val($(this).attr('data-name'));
    });

    $('.delete_supply').click(function() {
        if (confirm("Are you sure to delete this supply?")) {
            $.ajax({
                url: '/supplies/' + $(this).attr('data-id'),
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
            url: '/supplies',
            success: function(data) {
                var tableContent = $(data).find('#supply-table').html();
                $('#supply-table').html(tableContent);
                attachEventHandlers();
            }
        });
    }

    function attachEventHandlers() {
        $('.edit_supply').click(function() {
            var supply = $('#manage-supply');
            supply.get(0).reset();
            supply.find("[name='id']").val($(this).attr('data-id'));
            supply.find("[name='name']").val($(this).attr('data-name'));
        });

        $('.delete_supply').click(function() {
            if (confirm("Are you sure to delete this supply?")) {
                $.ajax({
                    url: '/supplies/' + $(this).attr('data-id'),
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
