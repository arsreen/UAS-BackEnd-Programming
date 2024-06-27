<?php
namespace App\Http\Controllers;

use App\Models\LaundryList;
use App\Models\LaundryCategory;
use App\Models\LaundryItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    public function index()
    {
        $laundryList = LaundryList::with('items')->get();
        return view('laundry.index', compact('laundryList'));
    }

    public function create()
    {
        $categories = LaundryCategory::all();
        return view('laundry.manage', compact('categories'));
    }
public function store(Request $request)
{
    $data = $request->all();

    // Save or update laundry data
    $laundry = LaundryList::updateOrCreate(
        ['id' => $request->id],
        [
            'customer_name' => $data['customer_name'],
            'status' => $data['status'] ?? 0,
            'remarks' => $data['remarks'],
            'pay_status' => $data['pay'] ?? 0,
            'amount_tendered' => $data['tendered'] ?? 0,
            'total_amount' => $data['tamount'] ?? 0,
            'amount_change' => $data['change'] ?? 0,
            'queue' => $data['queue'] ?? 1,
        ]
    );

    // Delete existing items if updating
    if($request->id) {
        LaundryItem::where('laundry_id', $request->id)->delete();
    }

    // Save laundry items
    if (isset($data['laundry_category_id'])) {
        foreach ($data['laundry_category_id'] as $index => $categoryId) {
            LaundryItem::create([
                'laundry_id' => $laundry->id,
                'laundry_category_id' => $categoryId,
                'weight' => $data['weight'][$index],
                'unit_price' => $data['unit_price'][$index],
                'amount' => $data['amount'][$index],
            ]);
        }
    }

    return response()->json(['status' => $request->id ? 2 : 1]);
}

    public function edit($id)
    {
        $laundry = LaundryList::with('items.category')->find($id);
        $categories = LaundryCategory::all();
        return view('laundry.manage', compact('laundry', 'categories'));
    }

    public function destroy($id)
    {
        $laundry = LaundryList::find($id);
        $laundry->items()->delete();
        $laundry->delete();

        return response()->json(['status' => 1]);
    }
}
