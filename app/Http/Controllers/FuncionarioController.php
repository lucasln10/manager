<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FuncionariosService;


class FuncionarioController extends Controller
{
    private $funcionarioService;

    public function __construct(FuncionariosService $funcionarioService)
    {
        $this->funcionarioService = $funcionarioService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $funcionarios = $this->funcionarioService->buscarFuncionarios($request->input('search'));
        return view('funcionarios', compact('funcionarios'));
    }

    public function create()
    {
        $cargos = $this->funcionarioService->buscarCargos();
        return view('funcionarios.create_funcionario', compact('cargos'));
    }

    public function store(Request $request)
    {
        $this->funcionarioService->criarFuncionario($request->all());
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário adicionado com sucesso!');
    }

    public function edit($id)
    {
        $cargos = $this->funcionarioService->buscarCargos();
        $funcionario = $this->funcionarioService->buscarPorId($id);
        return view('funcionarios.edit_funcionario', compact('funcionario', 'cargos'));
    }

    public function update(Request $request, $id)
    {
        $this->funcionarioService->criarFuncionario($request->all(), $id);
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try{
            $this->funcionarioService->deletar($id);
            return redirect()->route('funcionarios.index')->with('success', 'Funcionário excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('funcionarios.index')->with('error', $e->getMessage());
        }

    }
}
