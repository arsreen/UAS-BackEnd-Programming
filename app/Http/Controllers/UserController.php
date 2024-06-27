<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . ($request->id ?? 'NULL') . ',id',
            'password' => 'required_without:id|string|min:8',
            'type' => 'required|integer',
        ]);

        $data = $request->only('name', 'username', 'type', 'password');

        if ($request->id) {
            $user = User::find($request->id);
            $user->update($data);
        } else {
            User::create($data);
        }

        return response()->json(['status' => 1, 'message' => 'Data successfully saved']);
    }

    

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function destroy($id)
    {
        if (Auth::user()->type == 1) {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['status' => 1, 'message' => 'Data successfully deleted']);
        }
        return response()->json(['status' => 0, 'message' => 'Unauthorized action'], 403);
    }
}
