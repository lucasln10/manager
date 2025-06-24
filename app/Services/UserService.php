<?php

namespace App\Services;

use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryEloquent $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home.index');
        } else {
            throw new \Exception('Email ou senha inválidos');
        }
    }

    public function criarUsuario($data)
    {
        $data->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        return $this->userRepository->criarUsuario($data);
    }

    public function logout()
    {
        $logout = Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return $logout;
    }
}