<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home() {
        return view('home');
    }

    public function login(Request $request) {
        $request->validate([
            'uname' => 'string|required',
            'password' => 'string|required',
        ]);

        $user = User::where('uname', $request->uname)->first();

        if(!$user) {
            dd($request->all(), $user);
            return back()->with('Error','Sorry! User name ' . $request->user . ' is not found.');
        }

        if(!$user->active) {
            return back()->with('Error','Sorry your user account is INACTIVE. Please contact the systems administrator to activate your account.');
        }

        $user = auth()->attempt($request->only('uname','password'));

        if(!$user) {
            return back()->with('Error','Invalid user credentials');
        }

        return redirect('/home');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }
}
