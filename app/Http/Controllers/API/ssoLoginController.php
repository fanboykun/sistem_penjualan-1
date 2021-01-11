<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ssoLoginController extends Controller
{
    public function login(Request $request)
    {
    	$username=$request['request']['username'];
    	$password=$request['request']['password'];
		if(Auth::guard('web')->attempt(['username' => $username, 'password' => $password], false, false)) {
			return User::where('username',$username)->first();
		} else {
			return '422';
		}
    }
}
