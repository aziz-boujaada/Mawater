<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Villager;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Auth.register');
    }

    /**
     * Store a newly created resource in storage.
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
            $villager = Villager::create([
                'user_id' => $user->id,
                'subscription_status' => $data['subscription_status'],
                'cin' => $data['cin'],
                'address' => $data['address']
                
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'You are registerd new Villager with success',
                'user' => $villager,

            ], 201);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'You are registerd new ' . $user->role .  'with success',
            'user' => $user,

        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
