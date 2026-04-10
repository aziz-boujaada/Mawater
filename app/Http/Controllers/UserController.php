<?php 

namespace App\Http\Controllers;

use App\Models\User;

class UserController {
    public function index(){

       $users = User::with('villager')->paginate(10);
       return view('dashboards.users.index' , compact('users'));
    }
}