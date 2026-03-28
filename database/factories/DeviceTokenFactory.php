<?php

namespace NettSite\Messenger\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NettSite\Messenger\Models\DeviceToken;
use NettSite\Messenger\Models\MessengerUser;

/**
 * @extends Factory<DeviceToken>
 */
class DeviceTokenFactory extends Factory
{
    protected $model = DeviceToken::class;

    public function definition(): array
    {
        $user = MessengerUser::factory()->create();

        return [
            'user_type' => MessengerUser::class,
            'user_id' => $user->getKey(),
            'token' => fake()->uuid(),
            'platform' => fake()->randomElement(['android', 'ios']),
            'last_seen_at' => fake()->optional()->dateTimeThisMonth(),
        ];
    }

    public function android(): static
    {
        return $this->state(['platform' => 'android']);
    }

    public function ios(): static
    {
        return $this->state(['platform' => 'ios']);
    }
}
