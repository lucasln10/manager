@extends('layouts.main')

@section('content')
        <div class="space-y-4 md:space-y-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 md:gap-0">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Lista de Tarefas</h1>
                <x-button variant="success" href="{{ route('tarefas.create') }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nova Tarefa
                    </span>
                </x-button>
            </div>

            <x-card class="p-2 md:p-6">
                <!-- Barra de busca -->
                <form action="{{ route('tarefas.index') }}" method="GET" class="mb-4 md:mb-6">
                    <div class="flex flex-col md:flex-row gap-2">
                        <div class="flex-grow">
                            <input 
                                type="text" 
                                name="search" 
                                class="w-full px-2 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                                placeholder="Buscar por Funcionario, Cargo, Departamento"
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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Funcionário</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Criação</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Vencimento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider placeholder='00/00/0000' ">Data de Conclusão</th> <!-- NOVO -->
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tarefas as $tarefa)
                                <tr class="{{ $tarefa->urgente ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $tarefa->titulo }}
                                            @if($tarefa->urgente)
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Urgente
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $tarefa->funcionario->name ?? 'Não atribuído' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $tarefa->cargo->name ?? 'Não atribuído' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $tarefa->departamento->name ?? 'Não atribuído' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($tarefa->concluida)
                                                Concluída
                                            @elseif($tarefa->cancelada)
                                                Cancelada
                                            @elseif($tarefa->atrasada)
                                                Atrasada
                                            @elseif($tarefa->pendente)
                                                Pendente
                                            @else
                                                Em Andamento
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($tarefa->data_criacao)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($tarefa->data_vencimento)->format('d/m/Y') }}</div>
                                    </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if(isset($tarefa->data_conclusao))
                                                    {{ \Carbon\Carbon::parse($tarefa->data_conclusao)->format('d/m/Y') }}
                                                @else
                                                    <span class="text-gray-400 italic">--/--/----</span>
                                                @endif
                                            </div>
                                        </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('tarefas.edit', $tarefa->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                        <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">Nenhuma tarefa encontrada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
@endsection