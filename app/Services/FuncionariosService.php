<?php 

namespace App\Services;

use App\Repositories\FuncionarioRepositoryEloquent;


class FuncionariosService
{
    private $funcionarioRepository;

    public function __construct(FuncionarioRepositoryEloquent $funcionarioRepository)
    {
        $this->funcionarioRepository = $funcionarioRepository;
    }

    public function buscarFuncionarios($search)
    {
        return $this->funcionarioRepository->buscarFuncionarios($search);
    }

    public function buscarCargos()
    {
        return $this->funcionarioRepository->buscarCargos();
    }
    public function buscarPorId($id)
    {
        return $this->funcionarioRepository->buscarPorId($id);
    }

    public function criarFuncionario($data)
    {
        $data->validate([
            'name' => 'required|string|max:255',
            'nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf',
            'email' => 'required|email|max:255|unique:funcionarios,email',
            'telefone' => 'nullable|string|max:20',
            'cargo' => 'required|exists:cargos,id',
        ]);

        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $image = $data->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = md5($image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $image->move(public_path('img/funcionarios'), $imageName);
            $imagemPath = $imageName;
        } else {
            $imagemPath = null;
        }

        $this->funcionarioRepository->criarOuAtualizarFuncionario($data->all(), $imagemPath);
    }

    public function atualizarFuncionario($request, $id)
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
    }

    public function deletar($id)
    {
        if ($this->funcionarioRepository->funcionarioTemTarefas($id)) {
            throw new \Exception('Funcionário não pode ser excluído, pois possui tarefas associadas.');
        }
        return $this->funcionarioRepository->deletarFuncionario($id);
    }
}