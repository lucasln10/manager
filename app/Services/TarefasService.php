<?php

namespace App\Services;

use App\Repositories\TarefaRepositoryEloquent;
use Carbon\Carbon;

class TarefasService
{
    private $tarefaRepository;

    public function __construct(TarefaRepositoryEloquent $tarefaRepository)
    {
        $this->tarefaRepository = $tarefaRepository;
    }

    public function buscarTarefas($search)
    {
        return $this->tarefaRepository->buscarTarefas($search);
    }

    public function funcionariosCargosDepartamentos()
    {
        return $this->tarefaRepository->funcionariosCargosDepartamentos();
    }

    public function buscarPorId($id)
    {
        return $this->tarefaRepository->buscarPorId($id);
    }

    public function criarTarefa($data)
    {
        
        return $this->tarefaRepository->criarOuAtualizarTarefa($this->validarTarefa($data));
    }

    public function atualizarTarefa($data, $id)
    {
        return $this->tarefaRepository->criarOuAtualizarTarefa($this->validarTarefa($data), $id);
    }

    public function deletar($id)
    {
        if ($this->tarefaRepository->verificarTarefaComDependencia($id)) {
            throw new \Exception('Não é possível excluir esta tarefa, pois ela está vinculada a outras entidades.');
        }
        return $this->tarefaRepository->deleteTarefa($id);
    }

    public function validarTarefa($dados)
    {
        if (isset($dados['status'])) {
            $status = $dados['status'];

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
        if (!empty($dados['concluida'])) {
            $dados['data_conclusao'] = Carbon::now()->toDateTimeString();
        } else {
            $dados['data_conclusao'] = null;
        }

        return $dados;
    }
}
