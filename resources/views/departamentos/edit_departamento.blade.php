@extends('layouts.main')

@section('title', 'Editar Departamento')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Editar Departamento</h1>
        <x-button variant="secondary" href="{{ route('departamentos.index') }}">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </span>
        </x-button>
    </div>

    <x-card>
        <!-- Validação de erros -->
        @if ($errors->any())
            <x-alert type="error" message="Ops! Por favor, corrija os seguintes erros:" class="mb-6">
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ str_replace('The sigla has already been taken.', 'Esta sigla já está sendo utilizada por outro departamento.', $error) }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <!-- Formulário de edição -->
        <form action="{{ route('departamentos.update', $departamento->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Campo Nome -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                <input 
                    type="text"
                    name="name"
                    id="name"
                    required
                    maxlength="100"
                    value="{{ old('name', $departamento->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror"
                    placeholder="Digite o nome do departamento"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Sigla -->
            <div>
                <label for="sigla" class="block text-sm font-medium text-gray-700 mb-1">Sigla <span class="text-red-500">*</span></label>
                <input 
                    type="text"
                    name="sigla"
                    id="sigla"
                    required
                    maxlength="15"
                    value="{{ old('sigla', $departamento->sigla) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('sigla') border-red-500 @enderror"
                    placeholder="Digite a sigla do departamento"
                >
                @error('sigla')
                    <p class="mt-1 text-sm text-red-600">{{ str_replace('The sigla has already been taken.', 'Esta sigla já está sendo utilizada por outro departamento.', $message) }}</p>
                @enderror
            </div>

            <!-- Botões -->
            <div class="flex justify-end gap-4">
                <x-button type="submit" variant="primary">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Atualizar Departamento
                    </span>
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection