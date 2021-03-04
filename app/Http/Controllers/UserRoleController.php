<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRole;

class UserRoleController extends Controller
{
    //

    public function getUserRole(){
        return UserRole::all();
    }
}
