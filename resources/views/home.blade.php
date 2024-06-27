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

        </div>
    </div>

    <div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
                    {{ "Welcome back " . Auth::user()->name . "!" }}
                </div>
                <hr>
                <div class="row">
                    <div class="alert alert-success col-md-3 ml-4">
                        <p><b><large>Total Profit Today</large></b></p>
                        <hr>
                        <p class="text-right"><b><large>{{ number_format($totalProfit, 2) }}</large></b></p>
                    </div>
                    <div class="alert alert-info col-md-3 ml-4">
                        <p><b><large>Total Customers Today</large></b></p>
                        <hr>
                        <p class="text-right"><b><large>{{ number_format($totalCustomers) }}</large></b></p>
                    </div>
                    <div class="alert alert-primary col-md-3 ml-4">
                        <p><b><large>Total Claimed Laundry Today</large></b></p>
                        <hr>
                        <p class="text-right"><b><large>{{ number_format($totalClaimedLaundry) }}</large></b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
