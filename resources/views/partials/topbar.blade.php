<style>
    .logo {
        margin: auto;
        font-size: 20px;
        background: white;
        padding: 7px 11px;
        border-radius: 50% 50%;
        color: #000000b3;
    }
</style>

<nav class="navbar navbar-dark bg-dark fixed-top" style="padding:0;">
    <div class="container-fluid mt-2 mb-2">
        <div class="col-lg-12">
            <div class="col-md-1 float-left" style="display: flex;">
                <div class="logo">
                    <div class="laundry-logo"></div>
                </div>
            </div>
            <div class="col-md-4 float-left text-white">
                <large><b>Laundry Management System</b></large>
            </div>
            <div class="col-md-2 float-right text-white">
                <a href="/logout" class="text-white">{{ Auth::user()->name }} <i class="fa fa-power-off"></i></a>
            </div>
        </div>
    </div>
</nav>
