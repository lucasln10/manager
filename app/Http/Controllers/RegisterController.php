<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryEloquent $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function registerView()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $this->userRepository->criarUsuario($request);
        
        return redirect()->route('login.view');
    }
}
