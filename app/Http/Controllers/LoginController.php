<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function Login(Request $request)
    {
        $logins = [
            'admin' => '123456',
            'viewer' => '123456',
        ];

        // <<<<<<<<<<<<<<<<<<<<<<<<<<<< VALIDASI USERNAME & PASSWORD >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //
        if (in_array($request->username, array_keys($logins))) {
            if ($request->password === $logins[$request->username]) {
                session()->put('login', Crypt::encrypt($request->username));
                return redirect('home');
            }
        }
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<< VALIDASI USERNAME & PASSWORD >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //

        return redirect('employee/login');
    }

    public function Logout()
    {
        session()->flush();
        return redirect('employee/login');
    }
}
