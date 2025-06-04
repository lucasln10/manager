@extends('layouts.main')

@section('title', 'Cargos')

@section('content')
<div class="space-y-4 md:space-y-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 md:gap-0">
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Cargos</h1>
        <x-button variant="success" href="{{ route('cargos.create') }}">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Cargo
            </span>
        </x-button>
    </div>

    <x-card class="p-2 md:p-6">
        <!-- Barra de busca -->
        <form action="{{ route('cargos.index') }}" method="GET" class="mb-4 md:mb-6">
            <div class="flex flex-col md:flex-row gap-2">
                <div class="flex-grow">
                    <input 
                        type="text" 
                        name="search" 
                        class="w-full px-2 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="Buscar por nome do cargo" 
                        value="{{ request('search') }}"
                        autocomplete="off"
                        maxlength="100"
                    >
                </div>
                <x-button type="submit" variant="primary" class="w-full md:w-auto">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Buscar
                    </span>
                </x-button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-xs md:text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-2 py-2 md:px-6 md:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-2 py-2 md:px-6 md:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                        <th scope="col" class="px-2 py-2 md:px-6 md:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                        <th scope="col" class="px-2 py-2 md:px-6 md:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Nível</th>
                        <th scope="col" class="px-2 py-2 md:px-6 md:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                        <th scope="col" class="px-2 py-2 md:px-6 md:py-3 text-right font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($cargos as $cargo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 md:px-6 md:py-3 whitespace-nowrap text-sm text-gray-500">{{ $cargo->id }}</td>
                            <td class="px-2 py-2 md:px-6 md:py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $cargo->name }}</div>
                            </td>
                            <td class="px-2 py-2 md:px-6 md:py-3 text-sm text-gray-500">
                                <div class="max-w-xs truncate">{{ $cargo->descricao }}</div>
                            </td>
                            <td class="px-2 py-2 md:px-6 md:py-3 whitespace-nowrap text-sm text-gray-500">{{ $cargo->nivel }}</td>
                            <td class="px-2 py-2 md:px-6 md:py-3 whitespace-nowrap text-sm text-gray-500">{{ $cargo->departamento->sigla }}</td>
                            <td class="px-2 py-2 md:px-6 md:py-3 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('cargos.edit', $cargo->id) }}" 
                                       class="text-primary hover:text-primary-dark">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Editar
                                        </span>
                                    </a>
                                    <form action="{{ route('cargos.destroy', $cargo->id) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('Confirma a exclusão deste cargo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-2 py-2 md:px-6 md:py-3 text-center text-sm text-gray-500">
                                Nenhum cargo cadastrado até o momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="mt-6">
            {{ $cargos->withQueryString()->links() }}
        </div>
    </x-card>
</div>
@endsection