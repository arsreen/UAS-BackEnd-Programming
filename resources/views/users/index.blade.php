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
        <div class="col-lg-12">
            @if(Auth::user()->type == 1) <!-- Check if user is admin -->
            <button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New user</button>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card col-lg-12">
            <div class="card-body">
                <table class="table-striped table-bordered col-md-12">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $i => $user)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->username }}</td>
                            <td class="text-center">
                                @if(Auth::user()->type == 1) <!-- Check if user is admin -->
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary">Action</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item edit_user" href="javascript:void(0)" data-id="{{ $user->id }}">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="{{ $user->id }}">Delete</a>
                                        </div>
                                    </div>
                                </center>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $('#new_user').click(function() {
        $('#manageModal').modal('show');
        $('#manage-user').trigger("reset");
        $('#user_id').val('');
    })

    $('.edit_user').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/users/' + id + '/edit',
            method: 'GET',
            success: function(data) {
                $('#user_id').val(data.id);
                $('#name').val(data.name);
                $('#username').val(data.username);
                $('#type').val(data.type);
                $('#manageModal').modal('show');
            }
        });
    })

    $('#manage-user').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                if (resp.status == 1) {
                    alert("Data successfully saved");
                    $('#manageModal').modal('hide');
                    location.reload();
                } else {
                    alert("Failed to save data: " + resp.message);
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + xhr.responseText);
            }
        });
    })

    $('.delete_user').click(function() {
        if (confirm("Are you sure to delete this user?")) {
            delete_user($(this).data('id'));
        }
    })

    function delete_user(id) {
        $.ajax({
            url: '/users/' + id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if (resp.status == 1) {
                    alert("Data successfully deleted");
                    location.reload();
                } else {
                    alert("Failed to delete data: " + resp.message);
                }
            }
        })
    }
</script>
@endsection
@endsection
