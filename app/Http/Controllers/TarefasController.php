<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;
use App\Models\Funcionario;
use App\Models\Departamento;
use App\Models\Cargo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TarefasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchBool = null;
        if (strtolower($search) === 'sim' || $search === '1') {
            $searchBool = 1;
        } elseif (strtolower($search) === 'não' || strtolower($search) === 'nao' || $search === '0') {
            $searchBool = 0;
        }

        $tarefas = Tarefa::when($search, function ($query) use ($search, $searchBool) {
            $query->where(function ($q) use ($search, $searchBool) {
                $q->where('titulo', 'like', "%{$search}%");
                // Busca booleana só se o termo for sim/não/1/0
                if ($searchBool !== null) {
                    $q->orWhere('concluida', $searchBool)
                    ->orWhere('urgente', $searchBool)
                    ->orWhere('atrasada', $searchBool)
                    ->orWhere('cancelada', $searchBool)
                    ->orWhere('pendente', $searchBool);
                }
                // Busca por nome do funcionário
                $q->orWhereHas('funcionario', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                // Busca por nome do cargo
                ->orWhereHas('cargo', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                // Busca por nome do departamento
                ->orWhereHas('departamento', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        })->paginate(10);
        return view('tarefas', compact('tarefas'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        $cargos = Cargo::all();
        $funcionarios = Funcionario::all();
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

        $user = User::findOrFail(Auth::id());
        $dados = $request->all();
        $dados['user_id'] = $user->id;
        if ($request->has('concluida') && $request->concluida) {
            $dados['data_conclusao'] = Carbon::now()->toDateTimeString();
        } else {
            $dados['data_conclusao'] = null;
        }
        Tarefa::create($dados);
        return redirect()->route('tarefas.index')->with('success', 'Tarefa criada com sucesso');
    }

    public function edit($id)
    {
        $funcionarios = Funcionario::all();
        $departamentos = Departamento::all();
        $cargos = Cargo::all();
        $tarefa = Tarefa::findOrFail($id); // Corrigido: era Auth::id(), agora é o id da tarefa
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

        $tarefa = Tarefa::findOrFail($id);
        $dados = $request->all();
        $dados['user_id'] = Auth::id();
        // Garante que todos os campos booleanos sejam enviados (0 ou 1)

        if ($request->has('status')) {
            $status = $request->input('status');
            $dados['concluida'] = $status === 'concluida' ? 1 : 0;
            $dados['pendente'] = $status === 'pendente' ? 1 : 0;
            $dados['atrasada'] = $status === 'atrasada' ? 1 : 0;
            $dados['cancelada'] = $status === 'cancelada' ? 1 : 0;
            // Se quiser tratar "em_andamento" como todos os booleanos zerados:
            if ($status === 'em_andamento') {
                $dados['concluida'] = 0;
                $dados['pendente'] = 0;
                $dados['atrasada'] = 0;
                $dados['cancelada'] = 0;
            }
        }

        // Atualiza data_conclusao apenas se marcada como concluída
        if ($dados['concluida']) {
            $dados['data_conclusao'] = Carbon::now()->toDateTimeString();
        } else {
            $dados['data_conclusao'] = null;
        }

        // Atualiza campos booleanos de acordo com o status selecionado

        $tarefa->update($dados);
        return redirect()->route('tarefas.index')->with('success', 'Tarefa atualizada com sucesso');
    }

    public function destroy($id)
    {
        Tarefa::findOrFail($id)->delete();
        return redirect()->route('tarefas.index')->with('success', 'Tarefa excluída com sucesso');
    }
}