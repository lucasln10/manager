<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TarefasRepository;
use App\Models\Tarefa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Funcionario;
use App\Models\Cargo;
use App\Models\Departamento;
use App\Validators\TarefasValidator;

use function PHPUnit\Framework\isEmpty;

/**
 * Class TarefasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TarefaRepositoryEloquent extends BaseRepository implements TarefasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tarefa::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function buscarTarefas($search)
    {
        $searchBool = null;
        if (strtolower($search) === 'sim' || $search === '1') {
            $searchBool = 1;
        } elseif (strtolower($search) === 'não' || strtolower($search) === 'nao' || $search === '0') {
            $searchBool = 0;
        }

        return Tarefa::with(['funcionario', 'cargo', 'departamento'])
                        ->when($search, function ($query) use ($search, $searchBool) {
                        $query->where(function ($q) use ($search, $searchBool) {
                            $q->where('titulo', 'like', "%{$search}%");
                            // Busca booleana só se o termo for sim/não/1/0
                            if ($searchBool !== null) {
                                $q->orWhere('concluida', $searchBool)
                                ->orWhere('urgente', $searchBool)
                                ->orWhere('atrasada', $searchBool)
                                ->orWhere('cancelada', $searchBool)
                                ->orWhere('pendente', $searchBool);
                            }
                            // Busca por nome do funcionário
                            $q->orWhereHas('funcionario', function ($q2) use ($search) {
                                $q2->where('name', 'like', "%{$search}%");
                            })
                            // Busca por nome do cargo
                            ->orWhereHas('cargo', function ($q2) use ($search) {
                                $q2->where('name', 'like', "%{$search}%");
                            })
                            // Busca por nome do depa rtamento
                            ->orWhereHas('departamento', function ($q2) use ($search) {
                                $q2->where('name', 'like', "%{$search}%");
                                });
                            });
                        })->paginate(10);
    }

    public function criarOuAtualizarTarefa(array $request)
    {
        $user = Auth::id();
        $dados = $request;
        $dados['user_id'] = $user;

        if (isset($request['status'])) {
            $status = $request['status'];
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

        if (isset($dados['id'])) {
            $condicao = ['id' => $dados['id']];
            return Tarefa::updateOrCreate($condicao, $dados);
        } else {
            return Tarefa::create($dados);
        }
    }

    public function funcionariosCargosDepartamentos()
    {
        $funcionarios = Funcionario::all();
        $cargos = Cargo::all();
        $departamentos = Departamento::all();

        return [
            'funcionarios' => $funcionarios->pluck('name', 'id'),
            'cargos' => $cargos->pluck('name', 'id'),
            'departamentos' => $departamentos->pluck('name', 'id')
        ];
    }

    public function deletarTarefa($id)
    {
        $tarefa = Tarefa::find($id);
        return $tarefa->delete();
    }

}
