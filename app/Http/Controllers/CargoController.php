<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CargosService;

class CargoController extends Controller
{
    private $cargoService;
    private $cargoRepository;

    public function __construct(CargosService $cargoService)
    {
        $this->cargoService = $cargoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = $this->cargoService->buscarCargos(request()->input('search'));
        return view('cargos', compact('cargos'));
    }

    public function create()
    {
        $departamentos = $this->cargoService->nameIdDepartamentos();
        return view('cargos.create_cargos', compact('departamentos'));
    }


    public function store(Request $request)
    {
        $this->cargoService->criarCargo($request);
        return redirect()->route('cargos.index')->with('success', 'Cargo adicionado com sucesso!');
    }

    public function edit($id)
    {
        $departamentos = $this->cargoRepository->nameIdDepartamento();
        $cargo = $this->cargoService->buscarPorId($id);
        return view('cargos.edit_cargo', compact('cargo', 'departamentos'));
    }

    public function update(Request $request, $id)
    {
        $this->cargoService->atualizarCargo($request, $id);
        return redirect()->route('cargos.index')->with('success', 'Cargo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try{
            $this->cargoService->deletar($id);
            return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
        } catch(\Exception $e){
            return redirect()->route('cargos.index')->with('error', $e->getMessage());
        }
    }

}
