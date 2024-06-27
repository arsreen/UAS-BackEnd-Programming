<?php
namespace App\Http\Controllers;

use App\Models\SupplyList;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = SupplyList::all();
        return view('supplies.index', compact('supplies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($request->id) {
            $supply = SupplyList::find($request->id);
            $supply->name = $request->name;
            $supply->save();
            return response()->json(['status' => 2, 'message' => 'Data successfully updated']);
        } else {
            SupplyList::create($request->all());
            return response()->json(['status' => 1, 'message' => 'Data successfully added']);
        }
    }

    public function destroy($id)
    {
        $supply = SupplyList::findOrFail($id);
        $supply->delete();
        return response()->json(['status' => 1, 'message' => 'Data successfully deleted']);
    }
}
