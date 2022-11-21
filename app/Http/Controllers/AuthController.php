<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        dd('register');
    }
    public function login(){
        dd('login');
    }
    public function logout(){
        dd('logout');
    }
}
