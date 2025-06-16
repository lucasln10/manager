<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CargoRepository;
use App\Models\{Cargo, Departamento, User, Funcionario};
use Illuminate\Support\Facades\Auth;
use App\Validators\CargoValidator;

/**
 * Class CargoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CargoRepositoryEloquent extends BaseRepository implements CargoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cargo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function buscarCargo($name)
    {
        $cargos = Cargo::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })->paginate(10);
        return $cargos;
    }

    public function nameIdDepartamento()
    {
        return Departamento::all()->pluck('name', 'id');
    }

    public function criarOuAtualizarCargo($name, $descricao, $nivel, $departamento)
    {
        $userId = Auth::id();
        return Cargo::updateOrCreate([
            'name' => $name,
            'descricao' => $descricao,
            'nivel' => $nivel,
            'departamento_id' => $departamento,
            'user_id' => $userId, // Assuming you want to associate the cargo with the authenticated user
        ]);
    }

    public function deletarCargo($id)
    {
        $cargo = Cargo::findOrFail($id);
        return $cargo->delete();
    }

    public function verificarCargoTemFuncionarios($id)
    {
        $cargo = Funcionario::where('cargo_id', $id)->first();
        return $cargo;
    }
    
}
