<?php

namespace App\Http\Controllers\Webpanel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $prefix = 'back-end';
    public function getLogin()
    {
        return view("$this->prefix.auth.login", [
            'css' => [""],
            'prefix' => $this->prefix
        ]);
    }
    public function postLogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $remember = ($request->remember == 'on') ? true : false;
        if (Auth::attempt(['email' => $username, 'password' => $password, 'status' => 'active'], $remember)) 
        {
            if (Auth::user()->role == 'staff') 
            {
                return redirect('webpanel/');
            }   
            else if (Auth::user()->role == 'super admin') {
                return redirect('adminwebpanel/');  
            }
            else if (Auth::user()->role == 'admin') {
                return redirect('staffwebpanel/');  
            }
        } else {
            return redirect('webpanel\login')->with(['error' => 'Username or Password is incorrect!']);
        }
    }

    public function logOut()
    {
        if (!Auth::logout()) {
            return redirect("webpanel\login");
        }
    }
}
