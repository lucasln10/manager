<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TarefaRepositoryEloquent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TarefasController extends Controller
{
    private $tarefaRepository;

    public function __construct(TarefaRepositoryEloquent $tarefaRepository)
    {
        $this->tarefaRepository = $tarefaRepository;
    }
    /**
     * Busca as tarefas com base no termo de pesquisa.
     *
     * @param string|null $search
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function index(Request $request)
    {
        $tarefas = $this->tarefaRepository->buscarTarefas($request->input('search'));
        return view('tarefas', compact('tarefas'));
    }

    public function create()
    {
        $dados = $this->tarefaRepository->funcionariosCargosDepartamentos();
        $funcionarios = $dados['funcionarios'];
        $departamentos = $dados['departamentos'];
        $cargos = $dados['cargos'];
        return view('tarefas.create_tarefas', compact('departamentos', 'cargos', 'funcionarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_criacao' => 'required|date',
            'data_vencimento' => 'required|date',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'cargo_id' => 'required|exists:cargos,id',
            'urgente' => 'boolean',
            'concluida' => 'boolean',
            'pendente' => 'boolean',
            'atrasada' => 'boolean',
            'cancelada' => 'boolean'
        ]);

        $this->tarefaRepository->criarOuAtualizarTarefa($request->all());
        return redirect()->route('tarefas.index')->with('success', 'Tarefa criada com sucesso');
    }

    public function edit($id)
    {
        $dados = $this->tarefaRepository->funcionariosCargosDepartamentos();
        $funcionarios = $dados['funcionarios'];
        $departamentos = $dados['departamentos'];
        $cargos = $dados['cargos'];
        $tarefa = $this->tarefaRepository->findOrFail($id);
        return view('tarefas.edit_tarefas', compact('tarefa', 'funcionarios', 'departamentos', 'cargos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_criacao' => 'required|date',
            'data_vencimento' => 'required|date',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'cargo_id' => 'required|exists:cargos,id',
            'urgente' => 'nullable|boolean',
            'concluida' => 'nullable|boolean',
            'pendente' => 'nullable|boolean',
            'atrasada' => 'nullable|boolean',
            'cancelada' => 'nullable|boolean',
        ]);

        $this->tarefaRepository->criarOuAtualizarTarefa($request->all());
        return redirect()->route('tarefas.index')->with('success', 'Tarefa atualizada com sucesso');
    }

    public function destroy($id)
    {
        $this->tarefaRepository->delete($id);
        return redirect()->route('tarefas.index')->with('success', 'Tarefa excluída com sucesso');
    }
}