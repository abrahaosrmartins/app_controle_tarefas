<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class TarefaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'tarefa' => $this->faker->sentence(),
            'data_limite_conclusao' => $this->faker->date(),
            'user_id' => 1
        ];
    }
}
