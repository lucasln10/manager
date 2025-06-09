<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\DepartamentosFakeFactory;
use Database\Factories\CargosFakeFactory;
use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\Funcionario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Funcionario>
 */
class FuncionarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Funcionario::class;

    public function definition(): array
    {
        return [
        'name' => $this->faker->name(),
        'nascimento' => $this->faker->date(),
        'email' => $this->faker->unique()->safeEmail(),
        'cpf' => $this->faker->numerify('###########'),
        'telefone' => $this->faker->phoneNumber(),
        'image' => null,
        'cargo_id' => Cargo::inRandomOrder()->first()?->id ?? 1,
        'departamento_id' => Departamento::inRandomOrder()->first()?->id ?? 1,
        'user_id' => 1
        ];
    }
}
