<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;
use App\Models\Cargo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $funcionarios = Funcionario::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('cpf', 'like', "%{$search}%");
        })->paginate(10);

        return view('funcionarios', compact('funcionarios'));
    }

    public function create()
    {
        $cargos = DB::table('cargos')->pluck('name', 'id');
        return view('funcionarios.create_funcionario', compact('cargos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf',
            'email' => 'required|email|max:255|unique:funcionarios,email',
            'telefone' => 'nullable|string|max:20',
            'cargo' => 'required|exists:cargos,id',
        ]);

        $user = User::findOrFail(Auth::id());
        $cargo = Cargo::findOrFail($request->cargo);

        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = md5($image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $image->move(public_path('img/funcionarios'), $imageName);
            $imagemPath = $imageName;
        } else {
            $imagemPath = null;
        }
        Funcionario::create([
            'name' => $request->name,
            'nascimento' => $request->nascimento,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'cargo_id' => $cargo->id,
            'departamento_id' => $cargo->departamento_id,
            'image' => $imagemPath,
            'user_id' => $user->id, // Assuming you want to associate the funcionario with the authenticated user
        ]);


        return redirect()->route('funcionarios.index')->with('success', 'Funcionário adicionado com sucesso!');
    }

    public function edit($id)
    {
        $cargos = DB::table('cargos')->pluck('name', 'id');
        $funcionario = Funcionario::findOrFail($id);
        return view('funcionarios.edit_funcionario', compact('funcionario', 'cargos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf,' . $id,
            'email' => 'required|email|max:255|unique:funcionarios,email,' . $id,
            'telefone' => 'nullable|string|max:20',
            'cargo' => 'required|exists:cargos,id',
        ]);

        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = md5($image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $image->move(public_path('img/funcionarios'), $imageName);
            $imagemPath = $imageName;
        } else {
            $imagemPath = null;
        }


        $user = User::findOrFail(Auth::id());
        $cargo = Cargo::findOrFail($request->cargo);
        $funcionario = Funcionario::findOrFail($id);

        $funcionario->update([
            'name' => $request->name,
            'nascimento' => $request->nascimento,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'cargo_id' => $cargo->id,
            'departamento_id' => $cargo->departamento_id,
            'user_id' => $user->id,
            'image' => $imagemPath ?: $funcionario->image,
        ]);

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->delete();

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário excluído com sucesso!');
    }
}
