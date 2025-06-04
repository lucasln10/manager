@extends('layouts.main')

@section('title', 'Editar Funcionário')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Editar Funcionário</h1>
        <x-button variant="secondary" href="{{ route('funcionarios.index') }}">
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
        <form action="{{ route('funcionarios.update', $funcionario->id) }}" method="POST" class="space-y-6">
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
                    value="{{ old('name', $funcionario->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Data de Nascimento -->
            <div>
                <label for="nascimento" class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento <span class="text-red-500">*</span></label>
                <input 
                    type="date"
                    name="nascimento"
                    id="nascimento"
                    required
                    value="{{ old('nascimento', $funcionario->nascimento) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('nascimento') border-red-500 @enderror"
                >
                @error('nascimento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo CPF -->
            <div>
                <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF <span class="text-red-500">*</span></label>
                <input 
                    type="text"
                    name="cpf"
                    id="cpf"
                    required
                    maxlength="14"
                    value="{{ old('cpf', $funcionario->cpf) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('cpf') border-red-500 @enderror"
                >
                @error('cpf')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail <span class="text-red-500">*</span></label>
                <input 
                    type="email"
                    name="email"
                    id="email"
                    required
                    maxlength="100"
                    value="{{ old('email', $funcionario->email) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('email') border-red-500 @enderror"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Telefone -->
            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone <span class="text-red-500">*</span></label>
                <input 
                    type="text"
                    name="telefone"
                    id="telefone"
                    required
                    maxlength="15"
                    value="{{ old('telefone', $funcionario->telefone) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('telefone') border-red-500 @enderror"
                >
                @error('telefone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Cargo -->
            <div>
                <label for="cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo</label>
                <select 
                    name="cargo" 
                    id="cargo" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary @error('cargo') border-red-500 @enderror" 
                    required
                >
                    <option value="">Selecione o cargo</option>
                    @foreach($cargos as $id => $name)
                        <option value="{{ $id }}" 
                            {{ $id == old('cargo', $funcionario->cargo_id) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('cargo')
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
                        Atualizar Funcionário
                    </span>
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

@push('scripts')
    <!-- jQuery e jQuery Mask -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#telefone').mask('(00)00000-0000');
            $('#cpf').mask('000.000.000-00');
        });
    </script>
@endpush