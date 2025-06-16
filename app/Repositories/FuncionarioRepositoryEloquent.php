<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\FuncionarioRepository;
use App\Models\Funcionario;
use App\Models\Cargo;
use App\Models\Tarefa;
use Illuminate\Support\Facades\Auth;
use App\Validators\FuncionarioValidator;

/**
 * Class FuncionarioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FuncionarioRepositoryEloquent extends BaseRepository //implements FuncionarioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Funcionario::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function buscarFuncionarios($search)
    {
        return Funcionario::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('cpf', 'like', "%{$search}%");
        })->paginate(10);
    }

    public function buscarCargos()
    {
        return Cargo::all()->pluck('name', 'id');
    }

    public function criarOuAtualizarFuncionario($data, $imagePath)
    {
        $userId = Auth::id();
        $cargo = Cargo::find($data['cargo']);
        return Funcionario::updateOrCreate([
            'name' => $data['name'],
            'nascimento' => $data['nascimento'],
            'cpf' => $data['cpf'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'cargo_id' => $cargo,
            'departamento_id' => $cargo->departamento_id,
            'image' => $imagePath,
            'user_id' => $userId,
        ]);
    }
    
    public function deletarFuncionario($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return $funcionario->delete();
    }

    public function funcionarioTemTarefas($id)
    {
        $funcionario = Tarefa::where('funcionario_id', $id)->first();
        return $funcionario;
    }

}
