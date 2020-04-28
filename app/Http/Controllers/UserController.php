<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getProfile()
    {
        return Auth::user()->get();
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if(isset($request->name) && !empty($request->name))
        {
            $user->name = $request->name;
            $user->update();
        }

        return Auth::user()->get();
    }

    public function updateProfileImage(Request $request)
    {
        return $request->post('file');
    }

}
