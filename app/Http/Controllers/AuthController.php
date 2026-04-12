<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Villager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display register form.
     */
    public function registerForm()
    {
        return view('Auth.register');
    }

    /**
     * Display login form.
     */
    public function loginForm()
    {
        return view('Auth.login');
    }

    /**
     * Store a newly created user in storage.
     */
    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();
        
  
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => $data['role'],
                'phone' => $data['phone']
            ]);
        

        if ($data['role'] == 'villager') {
            Villager::create([
                'user_id' => $user->id,
                'subscription_status' => $data['subscription_status'],
                'cin' => $data['cin'],
                'address' => $data['address']
            ]);
        }

        return redirect()->route('users')->with('success', 'Registration new User successful');
    }

    /**
     * Handle login request.
     */
    public function login(LoginRequest $request)
    {
        $data = $request->only('email', 'password');
        
        if (!Auth::attempt($data)) {
            return redirect()->back()->withErrors(['email' => 'Invalid email or password']);
        }

        return redirect()->route('dashboard.admin')->with('success', 'You are logged in successfully!');
    }

    /**
     * Logout the user.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
