<?php

namespace NettSite\Messenger\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NettSite\Messenger\Models\MessengerUser;

/**
 * @extends Factory<MessengerUser>
 */
class MessengerUserFactory extends Factory
{
    protected $model = MessengerUser::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ];
    }
}
