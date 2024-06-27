<?php
namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\SupplyList;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $supplies = SupplyList::orderBy('name', 'asc')->get();
        $inventories = Inventory::orderBy('id', 'desc')->get();
        $supplyArr = $supplies->pluck('name', 'id')->toArray();

        foreach ($supplies as $supply) {
            $inn = Inventory::where('supply_id', $supply->id)->where('stock_type', 1)->sum('qty');
            $out = Inventory::where('supply_id', $supply->id)->where('stock_type', 2)->sum('qty');
            $supply->available = $inn - $out;
        }

        return view('inventory.index', compact('supplies', 'inventories', 'supplyArr'));
    }

    public function store(Request $request)
    {
        $inventory = Inventory::updateOrCreate(
            ['id' => $request->id],
            [
                'supply_id' => $request->supply_id,
                'qty' => $request->qty,
                'stock_type' => $request->stock_type,
                'date_created' => now()
            ]
        );

        return response()->json(['status' => 1, 'message' => 'Data successfully saved']);
    }

    public function edit($id)
    {
        $inventory = Inventory::find($id);
        return response()->json($inventory);
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return response()->json(['status' => 1, 'message' => 'Data successfully deleted']);
    }
}
