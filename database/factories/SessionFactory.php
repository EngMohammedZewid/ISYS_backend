<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Session::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title:en' => $this->faker->sentence(),
            'title:ar' => $this->faker->sentence(),
            'description:en' => $this->faker->sentence(),
            'description:ar' => $this->faker->sentence(),
            'speaker_job_title' => $this->faker->jobTitle,
            'speaker' => $this->faker->userName,
            'from' => $this->faker->time('H:i'),
            'to' => $this->faker->time('H:i'),
            'date' => $this->faker->date,
            'is_active' => $this->faker->boolean(80),
            'track_id' => $this->faker->boolean(50) ? Track::first()->id : null,
        ];
    }
}
