<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cargo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CargoController extends Controller
{
    public function index()
    {
        $search = request()->input('search');
        $cargos = Cargo::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })->paginate(10);

        return view('cargos', compact('cargos'));
    }

    public function create()
    {
        $departamentos = DB::table('departamentos')->pluck('name', 'id');
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

        $user = User::findOrFail(Auth::id());

        Cargo::create([
            'name' => $request->name,
            'descricao' => $request->descricao,
            'nivel' => $request->nivel,
            'departamento_id' => $request->departamento,
            'user_id' => $user->id, // Assuming you want to associate the cargo with the authenticated user
        ]);

        return redirect()->route('cargos.index')->with('success', 'Cargo adicionado com sucesso!');
    }

    public function edit($id)
    {
        $departamentos = DB::table('departamentos')->pluck('name', 'id');
        $cargo = Cargo::findOrFail($id);
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

        $user = User::findOrFail(Auth::id());
        $cargo = Cargo::findOrFail($id);
        $cargo->update([
            'name' => $request->name,
            'descricao' => $request->descricao,
            'nivel' => $request->nivel,
            'departamento_id' => $request->departamento,
            'user_id' => $user->id, // Assuming you want to update the cargo with the authenticated user
        ]);

        return redirect()->route('cargos.index')->with('success', 'Cargo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->delete();

        return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
    }

}
