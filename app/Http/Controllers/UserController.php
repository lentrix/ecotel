<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::orderBy('full_name')->get();

        return view('users.index',['users'=>$users]);
    }

    public function store(Request $request) {
       $fields = $request->validate([
            'uname' => 'string|required',
            'full_name' => 'string|required',
            'user_type' => 'string|required',
            'password' => 'string|required'
        ]);

        User::create($fields);

        return redirect('/users')->with('Info','A new user has been created.');
    }

    public function show(User $user) {
        return view('users.view',['user'=>$user]);
    }

    public function update(User $user, Request $request) {
        $user->update($request->all());
        return back()->with('Info','This user has been updated.');
    }

    public function changePassword(Request $request, User $user) {
        $request->validate([
            'password' => 'string|required|confirmed',
        ]);

        $user->update(['password'=>$request->password]);

        return back()->with('Info','The password of this user has been changed.');
    }

    public function destroy(User $user) {
        $name = $user->full_name;
        $user->delete();

        return redirect('/users')->with('Info','The user ' . $name . ' has been deleted.');
    }
}
