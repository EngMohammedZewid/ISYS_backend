<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name:en' => $this->faker->title(),
            'name:ar' => $this->faker->title(),
            'bio:en' => $this->faker->title(),
            'bio:ar' => $this->faker->title(),
            'description:en' => $this->faker->sentence(),
            'description:ar' => $this->faker->sentence(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
