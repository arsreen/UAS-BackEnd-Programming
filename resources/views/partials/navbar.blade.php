<style>
</style>

<nav id="sidebar" class="mx-lt-5 bg-dark">
    <div class="sidebar-list">
        <a href="/home" class="nav-item nav-home"><span class="icon-field"><i class="fa fa-home"></i></span> Home</a>
        <a href="/laundry" class="nav-item nav-laundry"><span class="icon-field"><i class="fa fa-water"></i></span> Laundry List</a>
        <a href="laundry-category" class="nav-item nav-categories"><span class="icon-field"><i class="fa fa-list"></i></span> Laundry Category</a>
        <a href="/supplies" class="nav-item nav-supply"><span class="icon-field"><i class="fa fa-boxes"></i></span> Supply List</a>
        <a href="/inventory" class="nav-item nav-inventory"><span class="icon-field"><i class="fa fa-list-alt"></i></span> Inventory</a>
        <a href="/reports" class="nav-item nav-reports"><span class="icon-field"><i class="fa fa-th-list"></i></span> Reports</a>
        @if(Auth::user()->type == 1)
            <a href="/users"  class="nav-item nav-users"><span class="icon-field"><i class="fa fa-users"></i></span> Users</a>
        @endif
    </div>
</nav>

<script>
    document.querySelector('.nav-{{ request()->route()->getName() }}').classList.add('active');
</script>

@if(Auth::user()->type == 2)
<style>
    .nav-sales, .nav-users {
        display: none !important;
    }
</style>
@endif
