<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\FuncionarioRepositoryEloquent;
use Illuminate\Support\Facades\Auth;


class FuncionarioController extends Controller
{
    private $funcionarioRepository;

    public function __construct(FuncionarioRepositoryEloquent $funcionarioRepository)
    {
        $this->funcionarioRepository = $funcionarioRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $funcionarios = $this->funcionarioRepository->buscarFuncionarios($request->input('search'));
        return view('funcionarios', compact('funcionarios'));
    }

    public function create()
    {
        $cargos = $this->funcionarioRepository->buscarCargos();
        return view('funcionarios.create_funcionario', compact('cargos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf',
            'email' => 'required|email|max:255|unique:funcionarios,email',
            'telefone' => 'nullable|string|max:20',
            'cargo' => 'required|exists:cargos,id',
        ]);

        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = md5($image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $image->move(public_path('img/funcionarios'), $imageName);
            $imagemPath = $imageName;
        } else {
            $imagemPath = null;
        }

        $this->funcionarioRepository->criarOuAtualizarFuncionario($request->all(), $imagemPath);
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário adicionado com sucesso!');
    }

    public function edit($id)
    {
        $cargos = $this->funcionarioRepository->buscarCargos();
        $funcionario = $this->funcionarioRepository->findOrFail($id);
        return view('funcionarios.edit_funcionario', compact('funcionario', 'cargos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf,' . $id,
            'email' => 'required|email|max:255|unique:funcionarios,email,' . $id,
            'telefone' => 'nullable|string|max:20',
            'cargo' => 'required|exists:cargos,id',
        ]);

        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = md5($image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $image->move(public_path('img/funcionarios'), $imageName);
            $imagemPath = $imageName;
        } else {
            $imagemPath = null;
        }

        $this->funcionarioRepository->criarOuAtualizarFuncionario($request->all(), $imagemPath);

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        if ($this->funcionarioRepository->funcionarioTemTarefas($id)) {
            return redirect()->route('funcionarios.index')->with('error', 'Funcionário não pode ser excluído, pois possui tarefas associadas.');
        } else {
            $this->funcionarioRepository->deletarFuncionario($id);
            return redirect()->route('funcionarios.index')->with('success', 'Funcionário excluído com sucesso!');
        }
    }
}
