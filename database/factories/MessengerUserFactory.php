<?php

namespace NettSite\Messenger\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NettSite\Messenger\Enums\UserStatus;
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
            'status' => UserStatus::Active,
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => UserStatus::Pending]);
    }

    public function suspended(): static
    {
        return $this->state(['status' => UserStatus::Suspended]);
    }
}
