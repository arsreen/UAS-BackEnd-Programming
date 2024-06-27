<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaundryCategory;

class LaundryCategoryController extends Controller
{
    public function index()
    {
        $categories = LaundryCategory::all();
        return view('laundry_category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        if ($request->id) {
            $category = LaundryCategory::find($request->id);
            $category->name = $request->name;
            $category->price = $request->price;
            $category->save();
            return response()->json(['status' => 2, 'message' => 'Data successfully updated']);
        } else {
            LaundryCategory::create($request->all());
            return response()->json(['status' => 1, 'message' => 'Data successfully added']);
        }
    }

    public function destroy(Request $request)
    {
        $category = LaundryCategory::find($request->id);
        $category->delete();
        return response()->json(['status' => 1, 'message' => 'Data successfully deleted']);
    }
}
