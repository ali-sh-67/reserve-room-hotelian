<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=> fake()->name(),
            'room_no'=>fake()->randomNumber(3,true),
            'address'=>fake()->address(),
            'type'=>null,
            'image'=>fake()->imageUrl,
            'video'=>fake()->imageUrl,
            'panorama'=>fake()->imageUrl,
        ];
    }
}
