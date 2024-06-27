<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $user = User::where('username', $credentials['username'])->first();

        if ($user && $this->checkPassword($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->put('user_type', Auth::user()->type);
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function home()
    {
        $today = date('Y-m-d');

        $totalProfit = DB::table('laundry_list')
            ->where('pay_status', 1)
            ->whereDate('date_created', $today)
            ->sum('total_amount');

        $totalCustomers = DB::table('laundry_list')
            ->whereDate('date_created', $today)
            ->count('id');

        $totalClaimedLaundry = DB::table('laundry_list')
            ->where('status', 3)
            ->whereDate('date_created', $today)
            ->count('id');

        return view('home', [
            'totalProfit' => $totalProfit,
            'totalCustomers' => $totalCustomers,
            'totalClaimedLaundry' => $totalClaimedLaundry
        ]);
    }

    protected function checkPassword($plainPassword, $hashedPassword)
    {
        // Replace this logic with your custom password verification logic
        // Example for plaintext password (not recommended):
        return $plainPassword === $hashedPassword;

        // If using a different hash algorithm, add appropriate logic here
        // Example for MD5 (not recommended):
        // return md5($plainPassword) === $hashedPassword;
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
