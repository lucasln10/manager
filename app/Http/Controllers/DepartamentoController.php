<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DepartamentosService;
use Carbon\Exceptions\Exception;

class DepartamentoController extends Controller
{
    private $departamentosService;
    private $departamentoRepository;

    public function __construct(DepartamentosService $departamentosService)
    {
        $this->departamentosService = $departamentosService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departamentos = $this->departamentosService->buscarDepartamentos(request()->input('search'));
        return view('departamentos', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create_departamento');
    }

    public function store(Request $request)
    {
        $this->departamentosService->criarDepartamento($request);
        return redirect()->route('departamentos.index')->with('success', 'Departamento adicionado com sucesso!');
    }

    public function edit($id)
    {
        $departamento = $this->departamentosService->buscarPorId($id);
        return view('departamentos.edit_departamento', compact('departamento'));
    }

    public function update(Request $request, $id)
    {
        $this->departamentosService->atualizarDepartamento($request, $id);
        return redirect()->route('departamentos.index')->with('success', 'Departamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $this->departamentosService->deletar($id);
            return redirect()->route('departamentos.index')->with('success', 'Departamento excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('departamentos.index')->with('error', $e->getMessage());
        }
    }
}