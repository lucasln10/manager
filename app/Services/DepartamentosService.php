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

    public function criarOuAtualizar($request, $id = null)
    {
        request()->validate([
            'name' => 'required|string|max:255|unique:departamentos,name,' . $id,
            'sigla' => 'required|string|max:10|unique:departamentos,sigla,' . $id,
        ]);

        $this->departamentoRepository->criarOuAtualizarDepartamento(
            $request->name,
            $request->sigla
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