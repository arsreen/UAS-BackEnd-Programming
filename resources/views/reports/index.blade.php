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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="d1" class="control-label">Date From</label>
                            <input type="date" class="form-control" name="d1" id="d1" value="{{ $d1 }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="d2" class="control-label">Date To</label>
                            <input type="date" class="form-control" name="d2" id="d2" value="{{ $d2 }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="filter" class="control-label">&nbsp;</label>
                            <button class="btn-block btn-primary btn-sm" type="button" id="filter">Filter</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="print" class="control-label">&nbsp;</label>
                            <button class="btn-block btn-primary btn-sm" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="print-data">
                    <div style="width:100%">
                        <p class="text-center">
                            <large><b>Laundry Management System Report</b></large>
                        </p>
                        <p class="text-center">
                            <large><b>Report for the period {{ $d1 }} to {{ $d2 }}</b></large>
                        </p>
                    </div>

                    <table class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laundryList as $laundry)
                            <tr>
                                <td>{{ date('M d, Y', strtotime($laundry->date_created)) }}</td>
                                <td>{{ ucwords($laundry->customer_name) }}</td>
                                <td class='text-right'>{{ number_format($laundry->total_amount, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No data available for the selected date range.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="2">Total</td>
                                <td class="text-right">{{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #print-data p {
        display: none;
    }
</style>
<noscript>
    <style>
        #div {
            width: 100%;
        }

        table {
            border-collapse: collapse;
            width: 100% !important;
        }

        tr,
        th,
        td {
            border: 1px solid black;
        }

        .text-right {
            text-align: right
        }

        .text-right {
            text-align: center
        }

        p {
            margin: unset;
        }

        #div p {
            display: block;
        }

        p.text-center {
            text-align: -webkit-center;
        }
    </style>
</noscript>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filter').click(function() {
            var d1 = $('#d1').val();
            var d2 = $('#d2').val();
            location.replace('{{ route("reports.index") }}' + '?d1=' + d1 + '&d2=' + d2);
        });

        $('#print').click(function() {
            var newWin = window.open('', '_blank', 'height=500,width=600');
            var _html = $('#print-data').clone();
            var ns = $('noscript').clone();
            newWin.document.write(ns.html());
            newWin.document.write(_html.html());
            newWin.document.close();
            newWin.print();
            setTimeout(function() {
                newWin.close();
            }, 1500);
        });
    });
</script>
@endsection
