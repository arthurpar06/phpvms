<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type'        => fake()->numberBetween(),
            'name'        => fake()->text(50),
            'description' => fake()->text(150),
            'start_date'  => fake()->date(),
            'end_date'    => fake()->date(),
            'active'      => true,
        ];
    }
}
