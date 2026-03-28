<?php

namespace NettSite\Messenger\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use NettSite\Messenger\Models\DeviceToken;
use NettSite\Messenger\Models\Group;
use NettSite\Messenger\Models\Message;
use NettSite\Messenger\Models\MessageReceipt;

trait HasMessenger
{
    public function deviceTokens(): MorphMany
    {
        return $this->morphMany(DeviceToken::class, 'user');
    }

    public function groups(): MorphToMany
    {
        return $this->morphToMany(Group::class, 'user', 'messenger_group_users');
    }

    public function messageReceipts(): MorphMany
    {
        return $this->morphMany(MessageReceipt::class, 'user');
    }

    public function registerDeviceToken(string $token, string $platform): DeviceToken
    {
        /** @var DeviceToken $deviceToken */
        $deviceToken = $this->deviceTokens()->updateOrCreate(
            ['token' => $token],
            ['platform' => $platform, 'last_seen_at' => now()],
        );

        return $deviceToken;
    }

    public function markMessageRead(Message $message): void
    {
        $this->messageReceipts()->updateOrCreate(
            ['message_id' => $message->getKey()],
            ['read_at' => now()],
        );
    }
}
