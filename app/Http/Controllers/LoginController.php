<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class LoginController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try{
            $this->userService->login($request);
            return redirect()->route('home.index');
        } catch(\Exception $e){
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }

    public function logout()
    {
        $this->userService->logout();
        return redirect()->route('login.view');
    }
}
