<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\CargoRepositoryEloquent;;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CargoController extends Controller
{
    private $cargoRepository;

    public function __construct(CargoRepositoryEloquent $cargoRepository)
    {
        $this->cargoRepository = $cargoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = $this->cargoRepository->buscarPorNome(request()->input('search'));
        return view('cargos', compact('cargos'));
    }

    public function create()
    {
        $departamentos = $this->cargoRepository->nameIdDepartamento();
        return view('cargos.create_cargos', compact('departamentos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cargos,name',
            'descricao' => 'nullable|string|max:500',
            'nivel' => 'required|string|min:1|max:50',
            'departamento' => 'required|exists:departamentos,id',
        ]);
        
        $this->cargoRepository->criarOuAtualizarCargo(
            $request->name,
            $request->descricao,
            $request->nivel,
            $request->departamento
        );

        return redirect()->route('cargos.index')->with('success', 'Cargo adicionado com sucesso!');
    }

    public function edit($id)
    {
        $departamentos = $this->cargoRepository->nameIdDepartamento();
        $cargo = $this->cargoRepository->findOrFail($id);
        return view('cargos.edit_cargo', compact('cargo', 'departamentos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cargos,name,' . $id,
            'descricao' => 'nullable|string|max:500',
            'nivel' => 'required|string|min:1|max:50',
            'departamento' => 'required|exists:departamentos,id',
        ]);

        $this->cargoRepository->criarOuAtualizarCargo(
            $request->name,
            $request->descricao,
            $request->nivel,
            $request->departamento
        );

        return redirect()->route('cargos.index')->with('success', 'Cargo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        if ($this->cargoRepository->verificarCargoTemFuncionarios($id)) {
            return redirect()->route('cargos.index')->with('error', 'Não é possível excluir este cargo, pois ele está associado a um ou mais funcionários.');
        }else {
            $this->cargoRepository->deletarCargo($id);
            return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
        }
    }

}
