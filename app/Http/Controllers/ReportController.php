<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaundryList;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $d1 = $request->input('d1');
        $d2 = $request->input('d2');

        // Default values for $d1 and $d2 if not provided
        if (!$d1) {
            $d1 = now()->startOfMonth()->toDateString();
        }
        if (!$d2) {
            $d2 = now()->endOfMonth()->toDateString();
        }

        // Retrieve data based on date range
        $laundryList = LaundryList::whereBetween('date_created', [$d1, $d2])->get();

        // Calculate total amount
        $total = $laundryList->sum('total_amount');

        // Prepare data to be passed to the view
        $data = [
            'd1' => $d1,
            'd2' => $d2,
            'laundryList' => $laundryList,
            'total' => $total
        ];

        return view('reports.index', $data);
    }
}
