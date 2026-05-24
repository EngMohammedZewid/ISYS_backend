<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title:en' => $this->faker->title(),
            'title:ar' => $this->faker->title(),
            'description:en' => $this->faker->sentence(),
            'description:ar' => $this->faker->sentence(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
