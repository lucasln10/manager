<?php 

namespace App\Services;

use App\Repositories\DepartamentoRepositoryEloquent;

class DepartamentosService
{
    private $departamentoRepository;

    public function __construct(DepartamentoRepositoryEloquent $departamentoRepository)
    {
        $this->departamentoRepository = $departamentoRepository;
    }

<<<<<<< HEAD
    public function criarOuAtualizar($request, $id = null)
=======
    public function buscarDepartamentos($search)
    {
        return $this->departamentoRepository->buscarDepartamentos($search);
    }
    
    public function buscarPorId($id)
    {
        return $this->departamentoRepository->buscarPorId($id);
    }

    public function criarDepartamento($request)
>>>>>>> 3b254d1adff98b7580a97594470c9dd099232f45
    {
        request()->validate([
            'name' => 'required|string|max:255|unique:departamentos,name,' . $id,
            'sigla' => 'required|string|max:10|unique:departamentos,sigla,' . $id,
        ]);

        $this->departamentoRepository->createDepartamento(
            $request->name,
            $request->sigla
        );
    }

    public function atualizarDepartamento($request, $id)
    {
        request()->validate([
            'name' => 'required|string|max:255|unique:departamentos,name,' . $id,
            'sigla' => 'required|string|max:10|unique:departamentos,sigla,' . $id,
        ]);

        return $this->departamentoRepository->updateDepartamento(
            $request->name,
            $request->sigla,
            $id
        );
    }

    public function deletar($id)
    {
        if ($this->departamentoRepository->verificarDepartamentoComCargo($id)) {
            throw new \Exception('Não é possível excluir este departamento, pois ele está vinculado a um cargo.');
        }
        return $this->departamentoRepository->deleteDepartamento($id);
    }

}