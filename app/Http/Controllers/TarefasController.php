<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;
use App\Models\Funcionario;
use App\Models\Departamento;
use App\Models\Cargo;

class TarefasController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::all();
        $cargos = Cargo::all();
        $departamentos = Departamento::all();
        $tarefas = Tarefa::with('funcionarios', 'departamentos', 'cargos')->get();
        return view('tarefas', compact('tarefas'));
    }

    public function create()
    {
        $cargos = Cargo::all();
        $departamentos = Departamento::all();
        $funcionarios = Funcionario::with('departamentos', 'cargos')->get();
        return view('tarefas.create_tarefas', compact('funcionarios', 'cargos', 'departamentos'));
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
            'urgente' => 'nullable|boolean'
        ]);

        Tarefa::create($request->all());
        return redirect()->route('tarefas.index')->with('success', 'Tarefa criada com sucesso');
    }

    public function edit(Tarefa $tarefa)
    {
        $cargos = Cargo::all();
        $departamentos = Departamento::all();
        $funcionarios = Funcionario::with('departamentos', 'cargos')->get();
        return view('tarefas.edit_tarefa', compact('tarefa', 'funcionarios', 'cargos', 'departamentos'));
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_criacao' => 'required|date',
            'data_vencimento' => 'required|date',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'cargo_id' => 'required|exists:cargos,id',
            'urgente' => 'nullable|boolean'
        ]);

        $tarefa->update($request->all());
        return redirect()->route('tarefas.index')->with('success', 'Tarefa atualizada com sucesso');
    }

    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();
        return redirect()->route('tarefas.index')->with('success', 'Tarefa excluída com sucesso');
    }
}