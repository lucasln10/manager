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
        $this->userRepository->criarUsuario($request->all());
        return redirect()->route('login.view');
    }
}
