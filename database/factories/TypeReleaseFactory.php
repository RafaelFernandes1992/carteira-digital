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
        $usersId = User::all()->pluck('id')->toArray();

        return [
            'descricao' => $this->faker->words(3, true),
            'rotineira' => $this->faker->randomElement([true, false]),
            'dedutivel' => $this->faker->randomElement([true, false]),
            'isenta' => $this->faker->randomElement([true, false]),
            'tipo' => $this->faker->randomElement(['receita', 'despesa', 'investimento']),
            'user_id' => $this->faker->randomElement($usersId)
        ];
    }
}
