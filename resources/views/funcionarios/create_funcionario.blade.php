@extends('layouts.main')

@section('title', 'Adicionar Funcionário')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Adicionar Funcionário</h1>
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
        <form action="{{ route('funcionarios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Campo Imagem -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Imagem de Perfil</label>
                <input 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" 
                    type="file" 
                    id="image" 
                    name="image"
                    accept="image/png, image/jpeg, image/jpg, image/gif, image/webp"
                    onchange="previewImagem(event)"
                >
                <div class="mt-3">
                    <img id="preview" src="#" alt="Pré-visualização da imagem" 
                        class="max-w-[200px] hidden border border-gray-300 p-1 rounded-md">
                </div>
            </div>

            <!-- Campo Nome -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo <span class="text-red-500">*</span></label>
                <input 
                    type="text"
                    name="name"
                    id="name"
                    required
                    maxlength="100"
                    value="{{ old('name') }}"
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
                    value="{{ old('nascimento') }}"
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
                    placeholder="000.000.000-00"
                    maxlength="14"
                    required
                    value="{{ old('cpf') }}"
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
                    value="{{ old('email') }}"
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
                    placeholder="(00) 00000-0000"
                    maxlength="15"
                    required
                    value="{{ old('telefone') }}"
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
                    <option value="">Selecione...</option>
                    @foreach($cargos as $id => $nome)
                        <option value="{{ $id }}" {{ old('cargo') == $id ? 'selected' : '' }}>
                            {{ $nome }}
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
                        Salvar Funcionário
                    </span>
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 00000-0000');
        });

        function previewImagem(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (!validTypes.includes(file.type)) {
                    alert('Por favor, envie apenas imagens (jpg, png, gif, webp).');
                    event.target.value = '';
                    return;
                }
                if (file.size > maxSize) {
                    alert('A imagem deve ter no máximo 2MB.');
                    event.target.value = '';
                    return;
                }
            }
        });
    </script>
@endpush