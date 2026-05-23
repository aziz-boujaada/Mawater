<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ListingQueryService;
use App\Services\UpdateProfileService;
use Illuminate\Http\Request;

class UserController
{
    public function index(Request $request)
    {
        $query = User::with('villager');

        ListingQueryService::apply($query, $request, [
            'search' => ['name', 'email', 'phone'],
            'exact' => [
                'role' => 'role',
            ],
            'date_field' => 'created_at',
        ]);

        $users = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        return view('dashboards.users.index', compact('users'));
    }


    public function showUser(int $id)
    {
        $user = User::with(['villager.meters.meterReadings'])->findOrFail($id);
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
