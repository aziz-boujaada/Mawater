<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\UpdateProfileService;

class UserController
{
    public function index()
    {

        $users = User::with('villager')->paginate(10);
        return view('dashboards.users.index', compact('users'));
    }


    public function showUser(int $id)
    {
        $user = User::with('villager')->where('id', $id)->first();
        return view('dashboards.users.show', compact('user'));
    }

    public function editUser(int $id)
    {
        $user = User::findOrFail($id);
        return view('dashboards.users.edit', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $requet, UpdateProfileService $updateProfileService , int $id)
    {

        $profile_data = $requet->validated();

        $user = User::findOrFail($id) ; 
        $updateProfileService->updateProfile($profile_data , $user);

        return redirect()->route('users')->with('success' , 'user updated successfully');
    }
}
