<?php

namespace Database\Factories;

use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Track::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title:en' => $this->faker->title(),
            'title:ar' => $this->faker->title(),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
