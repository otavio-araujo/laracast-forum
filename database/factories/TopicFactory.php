<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
