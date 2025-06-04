@extends('layouts.main')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('tarefas.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                        <input type="text" name="titulo" id="titulo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento</label>
                            <select name="departamento_id" id="departamento_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="filtrarCargos()" required>
                                <option value="">Selecione um departamento</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="cargo_id" class="block text-sm font-medium text-gray-700">Cargo</label>
                            <select name="cargo_id" id="cargo_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="filtrarFuncionarios()" required>
                                <option value="">Selecione um cargo</option>
                            </select>
                        </div>

                        <div>
                            <label for="funcionario_id" class="block text-sm font-medium text-gray-700">Funcionário</label>
                            <select name="funcionario_id" id="funcionario_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Selecione um funcionário</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="data_criacao" class="block text-sm font-medium text-gray-700">Data de Criação</label>
                        <input type="date" name="data_criacao" id="data_criacao" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="data_vencimento" class="block text-sm font-medium text-gray-700">Data de Vencimento</label>
                        <input type="date" name="data_vencimento" id="data_vencimento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="urgente" id="urgente" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="urgente" class="ml-2 block text-sm text-gray-900">
                                Tarefa Urgente
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('tarefas.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Armazenar dados dos funcionários
    const funcionarios = @json($funcionarios);
    const cargos = @json($cargos);

    function filtrarCargos() {
        const departamentoId = document.getElementById('departamento_id').value;
        const cargoSelect = document.getElementById('cargo_id');
        const funcionarioSelect = document.getElementById('funcionario_id');
        
        // Limpar selects
        cargoSelect.innerHTML = '<option value="">Selecione um cargo</option>';
        funcionarioSelect.innerHTML = '<option value="">Selecione um funcionário</option>';

        if (departamentoId) {
            // Filtrar cargos do departamento
            const cargosFiltrados = cargos.filter(cargo => cargo.departamento_id == departamentoId);
            
            cargosFiltrados.forEach(cargo => {
                const option = document.createElement('option');
                option.value = cargo.id;
                option.textContent = cargo.nome;
                cargoSelect.appendChild(option);
            });
        }
    }

    function filtrarFuncionarios() {
        const departamentoId = document.getElementById('departamento_id').value;
        const cargoId = document.getElementById('cargo_id').value;
        const funcionarioSelect = document.getElementById('funcionario_id');
        
        // Limpar select de funcionários
        funcionarioSelect.innerHTML = '<option value="">Selecione um funcionário</option>';

        if (departamentoId && cargoId) {
            // Filtrar funcionários do departamento e cargo
            const funcionariosFiltrados = funcionarios.filter(funcionario => 
                funcionario.departamento_id == departamentoId && 
                funcionario.cargo_id == cargoId
            );
            
            funcionariosFiltrados.forEach(funcionario => {
                const option = document.createElement('option');
                option.value = funcionario.id;
                option.textContent = funcionario.nome;
                funcionarioSelect.appendChild(option);
            });
        }
    }
</script>
@endpush
@endsection 