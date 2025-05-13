<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeRelease>
 */
class TypeReleaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $user = User::where('email', 'rafael.fernandes@example.com')->firstOrFail();

        $tipo = $this->faker->randomElement(['receita', 'despesa', 'investimento']);

        // Define os arrays para cada tipo
        $receitas = ['Salário', '13 Salário', 'Restituição de IR', 'Créditos da NFP', 'Bônus', 'PLR'];
        $despesas = ['Água', 'Luz', 'Telefone', 'Internet', 'Aluguel', 'Supermercado', 'Combustível', 'Farmácia', 'Escola', 'Seguro'];
        $investimentos = ['CDB', 'LCI', 'LCA', 'FII', 'FI', 'Ações', 'Tesouro Direto', 'ETF', 'Criptoativos', 'Fundos Multimercado'];

        // Define a descrição com base no tipo
        if ($tipo === 'receita') {
            $descricao = $this->faker->randomElement($receitas);
        } elseif ($tipo === 'despesa') {
            $descricao = $this->faker->randomElement($despesas);
        } elseif ($tipo === 'investimento') {
            $descricao = $this->faker->randomElement($investimentos);
        } else {
            $descricao = $this->faker->words(3, true); // fallback
        }

        return [
            'descricao' => $descricao,
            'rotineira' => $this->faker->randomElement([true, false]),
            'dedutivel' => $this->faker->randomElement([true, false]),
            'isenta' => $this->faker->randomElement([true, false]),
            'tipo' => $tipo,
            'user_id' => $user->id
        ];
    }

}
