@extends('layouts.main')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    Editar Tarefa
                </h2>

                <x-validation-errors class="mb-4" />

                <form action="{{ route('tarefas.update', $tarefa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Título + Urgente -->
                        <div class="md:col-span-2 flex items-center">
                            <div class="flex-1">
                                <x-label for="titulo" value="Título *" />
                                <x-input type="text" name="titulo" id="titulo" class="mt-1 block w-full" value="{{ old('titulo', $tarefa->titulo) }}" required />
                            </div>
                            <!-- Urgente -->
                            <div class="flex items-center ml-6 mt-7">
                                <input type="hidden" name="urgente" value="0">
                                <input type="checkbox" name="urgente" value="1" id="urgente" {{ old('urgente', $tarefa->urgente) ? 'checked' : '' }} class="form-checkbox h-8 w-8 text-red-600 border-gray-300 rounded-full focus:ring-red-500 ml-2">
                                <label for="urgente" class="ml-2 text-lg font-semibold select-none">Urgente</label>
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="md:col-span-2">
                            <x-label for="descricao" value="Descrição *" />
                            <textarea name="descricao" id="descricao" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('descricao', $tarefa->descricao) }}</textarea>
                        </div>

                        <!-- Departamento -->
                        <div>
                            <x-label for="departamento_id" value="Departamento *" />
                            <select name="departamento_id" id="departamento_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Selecione um departamento</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}" {{ old('departamento_id', $tarefa->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                        {{ $departamento->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cargo -->
                        <div>
                            <x-label for="cargo_id" value="Cargo *" />
                            <select name="cargo_id" id="cargo_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Selecione um cargo</option>
                            </select>
                        </div>

                        <!-- Funcionário -->
                        <div>
                            <x-label for="funcionario_id" value="Funcionário *" />
                            <select name="funcionario_id" id="funcionario_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Selecione um funcionário</option>
                            </select>
                        </div>

                        <!-- Data de Criação -->
                        <div>
                            <x-label for="data_criacao" value="Data de Criação *" />
                            <x-input type="date" name="data_criacao" id="data_criacao" class="mt-1 block w-full" value="{{ old('data_criacao', $tarefa->data_criacao) }}" required />
                        </div>

                        <!-- Data de Vencimento -->
                        <div>
                            <x-label for="data_vencimento" value="Data de Vencimento *" />
                            <x-input type="date" name="data_vencimento" id="data_vencimento" class="mt-1 block w-full" value="{{ old('data_vencimento', $tarefa->data_vencimento) }}" required />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-label for="status" value="Status *" />
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="pendente" {{ old('status', $tarefa->pendente) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="cancelada" {{ old('status', $tarefa->cancelada) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="concluida" {{ old('status', $tarefa->concluida) == 'concluida' ? 'selected' : '' }}>Concluída</option>
                                <option value="atrasada" {{ old('status', $tarefa->atrasada) == 'atrasada' ? 'selected' : '' }}>Atrasada</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="window.location='{{ route('tarefas.index') }}'">
                            Voltar para Lista
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cargos = @json($cargos);
        let funcionarios = @json($funcionarios);
        let oldDepartamentoId = "{{ old('departamento_id', $tarefa->departamento_id) }}";
        let oldCargoId = "{{ old('cargo_id', $tarefa->cargo_id) }}";
        let oldFuncionarioId = "{{ old('funcionario_id', $tarefa->funcionario_id) }}";

        function atualizarCargos(departamentoId = null, cargoId = null) {
            departamentoId = departamentoId || document.getElementById('departamento_id').value;
            let cargoSelect = document.getElementById('cargo_id');
            let funcionarioSelect = document.getElementById('funcionario_id');
            
            cargoSelect.innerHTML = '<option value="">Selecione um cargo</option>';
            funcionarioSelect.innerHTML = '<option value="">Selecione um funcionário</option>';
            
            if (!departamentoId) return;
            
            let cargoSelecionado = false;
            cargos.forEach(function(cargo) {
                if (String(cargo.departamento_id) === String(departamentoId)) {
                    let option = document.createElement('option');
                    option.value = cargo.id;
                    option.textContent = cargo.name || cargo.nome;
                    if (cargoId && String(cargo.id) === String(cargoId)) {
                        option.selected = true;
                        cargoSelecionado = true;
                    }
                    cargoSelect.appendChild(option);
                }
            });
            
            if (cargoSelecionado) {
                atualizarFuncionarios(cargoId, oldFuncionarioId);
            }
        }

        function atualizarFuncionarios(cargoId = null, funcionarioId = null) {
            cargoId = cargoId || document.getElementById('cargo_id').value;
            let funcionarioSelect = document.getElementById('funcionario_id');
            funcionarioSelect.innerHTML = '<option value="">Selecione um funcionário</option>';
            
            if (!cargoId) return;
            
            funcionarios.forEach(function(funcionario) {
                if (String(funcionario.cargo_id) === String(cargoId)) {
                    let option = document.createElement('option');
                    option.value = funcionario.id;
                    option.textContent = funcionario.name || funcionario.nome;
                    if (funcionarioId && String(funcionario.id) === String(funcionarioId)) {
                        option.selected = true;
                    }
                    funcionarioSelect.appendChild(option);
                }
            });
        }

        let departamentoSelect = document.getElementById('departamento_id');
        let cargoSelect = document.getElementById('cargo_id');

        departamentoSelect.addEventListener('change', function() {
            atualizarCargos(this.value, null);
        });

        cargoSelect.addEventListener('change', function() {
            atualizarFuncionarios(this.value, null);
        });

        if (oldDepartamentoId) {
            departamentoSelect.value = oldDepartamentoId;
            atualizarCargos(oldDepartamentoId, oldCargoId);
        }
    });
</script>
@endsection