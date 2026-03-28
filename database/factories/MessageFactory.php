<?php

namespace NettSite\Messenger\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NettSite\Messenger\Models\Message;
use NettSite\Messenger\Models\MessengerUser;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        $sender = MessengerUser::factory()->create();

        return [
            'body' => fake()->paragraph(),
            'url' => fake()->optional()->url(),
            'sender_type' => MessengerUser::class,
            'sender_id' => $sender->getKey(),
            'scheduled_at' => null,
            'sent_at' => null,
        ];
    }

    public function sent(): static
    {
        return $this->state(['sent_at' => now()]);
    }

    public function scheduled(): static
    {
        return $this->state(['scheduled_at' => now()->addHour()]);
    }
}
