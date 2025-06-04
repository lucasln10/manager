<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Departamento;
use App\Models\Cargo;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::with('cargo', 'departamento')->get();
        $departamentos = Departamento::all();
        $cargos = Cargo::all();

        return view('home', compact('funcionarios', 'departamentos', 'cargos'));
    }
}
