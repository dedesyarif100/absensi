<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function Login(Request $request)
    {
        // session_start(); /* Starts the session */
        /* Check Login form submitted */
        $logins = [
            'admin' => '123456',
            'viewer' => '123456',
        ];

        if (in_array($request->username, array_keys($logins))) {
            // dd($logins[$request->username]);
            if ($request->password === $logins[$request->username]) {
                // dd(Crypt::encrypt($request->username));
                session()->put('login', Crypt::encrypt($request->username));
                return redirect('home');
            }
        }

        return redirect('employee/login');
    }

    public function Logout()
    {
        session()->flush();
        return redirect('employee/login');
    }
}
