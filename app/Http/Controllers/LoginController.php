<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function login_post(Request $request)
    {
        $check = SuperAdmin::where('username', $request->username)->where('password', $request->password)->first();

        if ($check) {
            $request->session()->put('login', true);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'message' => 'username atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login');
    }
}
