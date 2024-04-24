<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{   
    public function index()
    {   
        $users = User::all();
        return view('index')->with('users', $users);
    }

    public function action(Request $request)
    {
        $validatedData = $request->validate([
            'action' => 'required|in:delete,block,unblock',
            'selected_users' => 'required|array|min:1',
            'selected_users.*' => 'integer|exists:users,id', 
        ]);

        $selectedUsers = User::whereIn('id', $validatedData['selected_users'])->get();
        
        switch ($validatedData['action']) {
            case 'delete':
                $selectedUsers->each->delete();
                return redirect()->intended('/users')->with('success', 'Users deleted successfully!');
            case 'block':
                $selectedUsers->each(function ($user) {
                    $user->status = 'blocked';
                    $user->save();
                    
                });
                return redirect()->intended('/users')->with('success', 'Users unblocked successfully!');
            case 'unblock':
                $selectedUsers->each(function ($user) {
                    $user->status = 'active'; 
                    $user->save();
                });
                return redirect()->intended('/users')->with('success', 'Users unblocked successfully!');
        }
        return back()->withErrors(['error' => 'Unexpected error occurred.']);
    }
}
