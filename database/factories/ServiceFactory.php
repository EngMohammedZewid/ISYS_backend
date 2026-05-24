<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsor>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

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
            'sort_number' => $this->faker->unique->numberBetween(1, 30),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
