<?php

namespace App\Repositories;

use App\Models\Cargo;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\DepartamentoRepository;
use App\Models\Departamento;
use Illuminate\Support\Facades\Auth;
use App\Validators\DepartamentoValidator;

/**
 * Class DepartamentoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DepartamentoRepositoryEloquent extends BaseRepository //implements DepartamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Departamento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function buscarPorDepartamento($search)
    {
        return Departamento::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('sigla', 'like', "%{$search}%");
            })->paginate(10);
    }

    public function criarOuAtualizarDepartamento($name, $sigla)
    {
        $userId = Auth::id();
        return Departamento::updateOrCreate([
            'name' => $name,
            'sigla' => $sigla,
            'user_id' => $userId,
        ]);
    }

    public function deleteDepartamento($id)
    {
        $departamento = Departamento::findOrFail($id);
        return $departamento->delete();
    }

    public function verificarDepartamentoComCargo($id)
    {
        $departamento = Cargo::where('departamento_id', $id)->exists();
        return $departamento;
    }


    
}
