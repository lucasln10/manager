<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DepartamentoController extends Controller
{
    public function index()
    {
        $search = request()->input('search');
        $departamentos = Departamento::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('sigla', 'like', "%{$search}%");
            })->paginate(10);

        return view('departamentos', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create_departamento');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|string|max:255|unique:departamentos,name',
            'sigla' => 'required|string|max:10|unique:departamentos,sigla',
        ]);

        Departamento::create([
            'name' => $request->name,
            'sigla' => $request->sigla,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento adicionado com sucesso!');
    }

    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('departamentos.edit_departamento', compact('departamento'));
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required|string|max:255|unique:departamentos,name,' . $id,
            'sigla' => 'required|string|max:10|unique:departamentos,sigla,' . $id,
        ]);


        $departamento = Departamento::findOrFail($id);
        $departamento->update([
            'name' => $request->name,
            'sigla' => $request->sigla,
            'user_id' => auth()->id(), // Assuming you want to update the departamento with the authenticated user
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento excluído com sucesso!');
    }
}