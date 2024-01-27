<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $from = User::inRandomOrder()->first()->id;

        return [
            'user_id'       => $from,
            'chatable_id'   => User::where('id','!=',$from)->inRandomOrder()->first()->id,
            'chatable_type' => 'App\Models\User',
            'message'       => $this->faker->text(),
            'seen'          => rand(0,1),
        ];
    }
}
