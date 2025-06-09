<?php

namespace Database\Factories;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departamento>
 */
class DepartamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Departamento::class;

    public function definition(): array
    {
        $nomes = [
            'Tecnologia da Informação', 'Recursos Humanos', 'Financeiro', 'Marketing', 'Vendas',
            'Operações', 'Jurídico', 'Logística', 'Compras', 'Pesquisa e Desenvolvimento',
            'Atendimento ao Cliente', 'Engenharia', 'Administrativo', 'Treinamento', 'Qualidade'
        ];
        $siglas = [
            'TI', 'RH', 'FIN', 'MKT', 'VEN', 'OPE', 'JUR', 'LOG', 'COM', 'P&D', 'SAC', 'ENG', 'ADM', 'TRE', 'QLD'
        ];

        // Garante unicidade pelo índice
        $index = $this->faker->unique()->numberBetween(0, count($nomes) - 1);

        return [
            'name' => $nomes[$index],
            'sigla' => $siglas[$index],
            'user_id' => 1
        ];
    }
}
