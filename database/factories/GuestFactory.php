<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guest>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'address' => fake()->address,
            'country' => fake()->country,
            'phone' => fake()->phoneNumber,
            'idno' => fake()->numerify("#-####-###"),
            'email' => fake()->safeEmail,
            'company' => fake()->company,
            'company_address' => fake()->address,
            'company_tin' => fake()->numerify("###-###-###"),
            'added_by' => 1
        ];
    }
}
