<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\DepartamentosFakeFactory;
use App\Models\Departamento;
use App\Models\Cargo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cargo>
 */
class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Cargo::class;

    public function definition(): array
    {
        static $used = [];
        $nomes = [
           'Analista de Sistemas', 'Desenvolvedor Backend', 'Desenvolvedor Frontend', 'Gerente de Projetos',
           'Analista de Suporte', 'Administrador de Redes', 'Designer UX', 'Engenheiro de Dados',
           'Coordenador de TI', 'Analista de QA', 'Product Owner', 'Scrum Master', 'DevOps', 'Arquiteto de Software',
           'Analista de Negócios', 'Tester', 'Analista de Infraestrutura', 'Consultor SAP', 'Analista de BI', 'Gerente de Produto'
        ];
        $nome = $this->faker->unique()->randomElement($nomes);
        return [
        'name' => $nome,
        'descricao' => $this->faker->text(),
        'nivel' => $this->faker->randomElement(['Júnior', 'Pleno', 'Sênior']),
        'departamento_id' => Departamento::inRandomOrder()->first()?->id ?? 1,
        'user_id' => 1
        ];
    }
}
