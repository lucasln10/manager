@extends('layouts.main')

@section('title', 'Editar Cargo')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Editar Cargo</h1>
        <x-button variant="secondary" href="{{ route('cargos.index') }}">
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
            <x-alert type="error" class="mb-6">
                <strong>Ops!</strong> Houve alguns problemas com seus dados.
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <!-- Formulário de edição -->
        <form action="{{ route('cargos.update', $cargo->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Campo Nome -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Cargo <span class="text-red-500">*</span></label>
                <input 
                    type="text"
                    name="name"
                    id="name"
                    required
                    maxlength="100"
                    value="{{ old('name', $cargo->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Descrição -->
            <div>
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <textarea 
                    name="descricao" 
                    id="descricao" 
                    rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('descricao') border-red-500 @enderror" 
                    maxlength="255"
                >{{ old('descricao', $cargo->descricao) }}</textarea>
                @error('descricao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Nível -->
            <div>
                <label for="nivel" class="block text-sm font-medium text-gray-700 mb-1">Nível <span class="text-red-500">*</span></label>
                <input 
                    type="text"
                    name="nivel"
                    id="nivel"
                    required
                    maxlength="50"
                    value="{{ old('nivel', $cargo->nivel) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('nivel') border-red-500 @enderror"
                >
                @error('nivel')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Departamento -->
            <div>
                <label for="departamento" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                <select 
                    name="departamento" 
                    id="departamento" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('departamento') border-red-500 @enderror" 
                    required
                >
                    <option value="">Selecione...</option>
                    @foreach($departamentos as $id => $nome)
                        <option value="{{ $id }}" {{ old('departamento', $cargo->departamento_id) == $id ? 'selected' : '' }}>
                            {{ $nome }}
                        </option>
                    @endforeach
                </select>
                @error('departamento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botões -->
            <div class="flex justify-end gap-4">
                <x-button type="submit" variant="primary">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Atualizar Cargo
                    </span>
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#departamento').select2({
                placeholder: "Selecione ou pesquise um departamento",
                theme: "tailwind"
            });
        });
    </script>
@endpush