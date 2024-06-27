<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laundry Management System</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-te-1.4.0.css') }}" rel="stylesheet">
</head>

<body>
    @include('partials.topbar')
    <div class="container-fluid">
        <div class="row">
            @include('partials.navbar')
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <div id="preloader"></div>
    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Modal -->
    <div class="modal fade" id="manageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="manage-user" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Manage User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="user_id">
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label">User Type</label>
                            <select name="type" id="type" class="custom-select">
                                <option value="1">Admin</option>
                                <option value="2">Staff</option>
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

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('vendor/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendor/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('font-awesome/js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-te-1.4.0.min.js') }}" charset="utf-8"></script>
    <script>
        window.start_load = function() {
            $('body').prepend('<div id="preloader2"></div>')
        }
        window.end_load = function() {
            $('#preloader2').fadeOut('fast', function() {
                $(this).remove();
            })
        }
        window.uni_modal = function($title = '', $url = '', $size = '') {
            start_load()
            $.ajax({
                url: $url,
                error: err => {
                    console.log(err)
                    alert("An error occured")
                },
                success: function(resp) {
                    if (resp) {
                        $('#manageModal .modal-title').html($title)
                        $('#manageModal .modal-body').html(resp)
                        if ($size != '') {
                            $('#manageModal .modal-dialog').addClass($size)
                        } else {
                            $('#manageModal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
                        }
                        $('#manageModal').modal('show')
                        end_load()
                    }
                }
            })
        }
        window._conf = function($msg = '', $func = '', $params = []) {
            $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
            $('#confirm_modal .modal-body').html($msg)
            $('#confirm_modal').modal('show')
        }
        window.alert_toast = function($msg = 'TEST', $bg = 'success') {
            $('#alert_toast').removeClass('bg-success')
            $('#alert_toast').removeClass('bg-danger')
            $('#alert_toast').removeClass('bg-info')
            $('#alert_toast').removeClass('bg-warning')

            if ($bg == 'success')
                $('#alert_toast').addClass('bg-success')
            if ($bg == 'danger')
                $('#alert_toast').addClass('bg-danger')
            if ($bg == 'info')
                $('#alert_toast').addClass('bg-info')
            if ($bg == 'warning')
                $('#alert_toast').addClass('bg-warning')
            $('#alert_toast .toast-body').html($msg)
            $('#alert_toast').toast({
                delay: 3000
            }).toast('show');
        }
        $(document).ready(function() {
            $('#preloader').fadeOut('fast', function() {
                $(this).remove();
            })
        })
    </script>
    @yield('scripts')
</body>
</html>
