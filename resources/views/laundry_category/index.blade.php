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
            <form action="" id="manage-category">
                @csrf
                <div class="card">
                    <div class="card-header">
                        Laundry Category Form
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <textarea name="name" id="" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Price per kg.</label>
                            <input type="number" class="form-control text-right" min="1" step="any" name="price">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-category').get(0).reset()"> Cancel</button>
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
                        <tbody id="category-table">
                            @foreach($categories as $i => $category)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>
                                    <p>Name : <b>{{ $category->name }}</b></p>
                                    <p>Price : <b>{{ number_format($category->price, 2) }}</b></p>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary edit_cat" type="button" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-price="{{ $category->price }}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete_cat" type="button" data-id="{{ $category->id }}">Delete</button>
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
    $('#manage-category').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/laundry-category',
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
                $('#manage-category').get(0).reset();
            }
        });
    });

    $('.edit_cat').click(function() {
        var cat = $('#manage-category');
        cat.get(0).reset();
        cat.find("[name='id']").val($(this).attr('data-id'));
        cat.find("[name='name']").val($(this).attr('data-name'));
        cat.find("[name='price']").val($(this).attr('data-price'));
    });

    $('.delete_cat').click(function() {
        if (confirm("Are you sure to delete this category?")) {
            $.ajax({
                url: 'laundry-category/delete',
                method: 'POST',
                data: {
                    id: $(this).attr('data-id'),
                    _token: '{{ csrf_token() }}'
                },
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
            url: '{{ route("laundry.category") }}',
            success: function(data) {
                var tableContent = $(data).find('#category-table').html();
                $('#category-table').html(tableContent);
                attachEventHandlers();
            }
        });
    }

    function attachEventHandlers() {
        $('.edit_cat').click(function() {
            var cat = $('#manage-category');
            cat.get(0).reset();
            cat.find("[name='id']").val($(this).attr('data-id'));
            cat.find("[name='name']").val($(this).attr('data-name'));
            cat.find("[name='price']").val($(this).attr('data-price'));
        });

        $('.delete_cat').click(function() {
            if (confirm("Are you sure to delete this category?")) {
                $.ajax({
                    url: '/laundry-category/delete',
                    method: 'POST',
                    data: {
                        id: $(this).attr('data-id'),
                        _token: '{{ csrf_token() }}'
                    },
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
</script>
@endsection
@endsection
