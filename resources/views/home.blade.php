@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-2 md:px-4 py-4 md:py-6">
    <h1 class="text-center text-2xl md:text-3xl font-bold text-dark mb-2">Olá, Bem-vindo ao Melhor Gerenciador de Funcionários!</h1>
    <p class="text-center text-gray-600 mb-4 md:mb-8 text-base md:text-lg">Veja abaixo os funcionários cadastrados no sistema</p>

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-transform hover:-translate-y-1 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-2">{{ $funcionarios->count() }}</h2>
            <p class="text-gray-700 font-medium">Funcionários</p>
        </div>

        <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-transform hover:-translate-y-1 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-2">{{ $cargos->count() ?? 0 }}</h2>
            <p class="text-gray-700 font-medium">Cargos</p>
        </div>

        <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-transform hover:-translate-y-1 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-2">{{ $departamentos->count() ?? 0 }}</h2>
            <p class="text-gray-700 font-medium">Departamentos</p>
        </div>
    </div>

    <!-- Tabela -->
    <div class="bg-white rounded-xl shadow-md p-2 md:p-4 overflow-x-auto">
        <table class="min-w-full table-auto text-xs md:text-sm text-center">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="px-2 md:px-4 py-2">ID</th>
                    <th class="px-2 md:px-4 py-2">Nome</th>
                    <th class="px-2 md:px-4 py-2">Email</th>
                    <th class="px-2 md:px-4 py-2">Cargo</th>
                    <th class="px-2 md:px-4 py-2">Departamento</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($funcionarios as $funcionario)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-2 md:px-4 py-2">{{ $funcionario->id }}</td>
                        <td class="px-2 md:px-4 py-2">{{ $funcionario->name }}</td>
                        <td class="px-2 md:px-4 py-2">{{ $funcionario->email }}</td>
                        <td class="px-2 md:px-4 py-2">{{ $funcionario->cargo->name ?? 'Sem cargo' }}</td>
                        <td class="px-2 md:px-4 py-2">{{ $funcionario->departamento->name ?? 'Sem departamento' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-2 md:px-4 py-4 text-center text-gray-500">Nenhum funcionário cadastrado no momento.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection