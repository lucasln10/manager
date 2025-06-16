<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\repositories\DepartamentoRepositoryEloquent;
use Illuminate\Support\Facades\Auth;

class DepartamentoController extends Controller
{
    private $departamentoRepository;

    public function __construct(DepartamentoRepositoryEloquent $departamentoRepository)
    {
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
        request()->validate([
            'name' => 'required|string|max:255|unique:departamentos,name',
            'sigla' => 'required|string|max:10|unique:departamentos,sigla',
        ]);

        $departamento = $this->departamentoRepository->criarOuAtualizarDepartamento(
            $request->name,
            $request->sigla
        );


        return redirect()->route('departamentos.index')->with('success', 'Departamento adicionado com sucesso!');
    }

    public function edit($id)
    {
        $departamento = $this->departamentoRepository->findOrFail($id);
        return view('departamentos.edit_departamento', compact('departamento'));
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required|string|max:255|unique:departamentos,name,' . $id,
            'sigla' => 'required|string|max:10|unique:departamentos,sigla,' . $id,
        ]);

        $this->departamentoRepository->criarOuAtualizarDepartamento(
            $request->name,
            $request->sigla,
        );

        return redirect()->route('departamentos.index')->with('success', 'Departamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        if ($this->departamentoRepository->verificarDepartamentoComCargo($id)) {
            return redirect()->route('departamentos.index')->with('error', 'Não é possível excluir este departamento, pois ele está vinculado a um cargo.');
        }else {
            $this->departamentoRepository->deleteDepartamento($id);
            return redirect()->route('departamentos.index')->with('success', 'Departamento excluído com sucesso!');
        }
    }
}