<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\CargosFakeFactory;
use Database\Factories\DepartamentosFakeFactory;
use Database\Factories\FuncionariosFakeFactory;
use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\Funcionario;
use App\Models\Tarefa;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarefa>
 */
class TarefaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tarefa::class;

    public function definition(): array
    {
        return [
        'titulo' => $this->faker->sentence(),
        'descricao' => $this->faker->text(),
        'data_criacao' => now(),
        'data_vencimento' => $this->faker->date(),
        'data_conclusao' => $this->faker->date(),
        'concluida' => 0,
        'urgente' => $this->faker->boolean(),
        'funcionario_id' => Funcionario::inRandomOrder()->first()?->id ?? 1,
        'departamento_id' => Departamento::inRandomOrder()->first()?->id ?? 1,
        'cargo_id' => Cargo::inRandomOrder()->first()?->id ?? 1,
        'user_id' => 1
        ];
    }
}
