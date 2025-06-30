<?php 

namespace App\Services;

use App\Repositories\CargoRepositoryEloquent;

class CargosService
{
    private $cargoRepository;

    public function __construct(CargoRepositoryEloquent $cargoRepository)
    {
        $this->cargoRepository = $cargoRepository;
    }

    public function buscarCargos($search)
    {
        return $this->cargoRepository->buscarCargos($search);
    }

    public function nameIdDepartamentos()
    { 
        return $this->cargoRepository->nameIdDepartamento();
    }

    public function buscarPorId($id)
    {
        return $this->cargoRepository->findOrFail($id);
    }

    public function criarCargo($request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cargos,name',
            'descricao' => 'nullable|string|max:500',
            'nivel' => 'required|string|min:1|max:50',
            'departamento' => 'required|exists:departamentos,id',
        ]);
        
        $this->cargoRepository->criarCargo(
            $request->name,
            $request->descricao,
            $request->nivel,
            $request->departamento
        );
    }

    public function atualizarCargo($request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cargos,name,' . $id,
            'descricao' => 'nullable|string|max:500',
            'nivel' => 'required|string|min:1|max:50',
            'departamento' => 'required|exists:departamentos,id',
        ]);
        
        return $this->cargoRepository->atualizarCargo(
            $request->name,
            $request->descricao,
            $request->nivel,
            $request->departamento,
            $id
        );
    }

    public function deletar($id)
    {
        if ($this->cargoRepository->verificarCargoTemFuncionarios($id)){
            throw new \Exception('Não é possível excluir este cargo, pois ele está vinculado a um funcionário.');
        }
        return $this->cargoRepository->deleteCargo($id);
    }

}