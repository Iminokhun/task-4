<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DateTime;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function login()
    {   
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            if(Auth::user()->status === 'blocked')
            {
                Auth::logout();
                return back()->with('error', 'Your account is blocked');
            }
            $user = Auth::user();
            $user->last_login_at = new DateTime();
            Auth::user()->save();            
            $request->session()->regenerate();

            return redirect()->intended('/users');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register_store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:1',
            'password_confirmation' => 'required|same:password',
        ]);
        $validate['last_login_at'] = Carbon::now();
        $user = User::create($validate);
        

        auth()->login($user);
        return redirect('/users')->with('success', 'Account successfully registered');
    }
   
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect('/login');
    }
}
