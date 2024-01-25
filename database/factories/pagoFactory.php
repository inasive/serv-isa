<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class pagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement([1,2]),
            'total' => fake()->faker()->number(500),
            'estado' => fake()->randomElement([0, 1]),
            'monto' => fake()->random([500, 2000]),
            'iva' => fake()->number(16),
            'estado' => fake()->number(1),
            'pago_verificador' => fake()->randomElement([500 , 2000]),
            'siniestro_id' => fake()->numberBetween(1,10),
        ];
    }
    
}
