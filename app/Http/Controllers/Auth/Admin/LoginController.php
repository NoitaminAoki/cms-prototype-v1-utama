<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.admin.login');
    }
    
    public function login(Request $request)
    {
        $this->validator($request);
        
        if(Auth::guard('admin')->attempt($request->only('email','password'))){
            //Authentication passed...
            return redirect()->route('dashboard');
        }
    }
    
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];
        
        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];
        
        //validate the request.
        $request->validate($rules,$messages);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
