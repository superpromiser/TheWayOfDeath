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

    public function createUserRole(Request $request){
        $roleName = $request->roleName;
        return UserRole::create(['roleName'=>$roleName]);
    }

    public function updateUserRole(Request $request){
        $id = $request->id;
        $roleName = $request->roleName;
        return UserRole::where('id',$id)->update(['roleName'=>$roleName]);
    }

    public function deleteUserRole(Request $request){
        $id = $request->id;
        return UserRole::where('id',$id)->delete();
    }
}
