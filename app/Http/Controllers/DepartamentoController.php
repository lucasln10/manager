<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DepartamentosService;
use App\Repositories\DepartamentoRepositoryEloquent;
use Carbon\Exceptions\Exception;

class DepartamentoController extends Controller
{
    private $departamentosService;
    private $departamentoRepository;

    public function __construct(DepartamentosService $departamentosService, DepartamentoRepositoryEloquent $departamentoRepository)
    {
        $this->departamentosService = $departamentosService;
        $this->departamentoRepository = $departamentoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos = $this->departamentoRepository->buscarPorDepartamento(request()->input('search'));
        return view('departamentos', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create_departamento');
    }

    public function store(Request $request)
    {
        $this->departamentosService->criarOuAtualizar($request);
        return redirect()->route('departamentos.index')->with('success', 'Departamento adicionado com sucesso!');
    }

    public function edit($id)
    {
        $departamento = $this->departamentoRepository->findOrFail($id);
        return view('departamentos.edit_departamento', compact('departamento'));
    }

    public function update(Request $request)
    {
        $this->departamentosService->criarOuAtualizar($request);
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