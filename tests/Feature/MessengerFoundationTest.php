<?php

use NettSite\Messenger\Models\DeviceToken;
use NettSite\Messenger\Models\Group;
use NettSite\Messenger\Models\Message;
use NettSite\Messenger\Models\MessageReceipt;
use NettSite\Messenger\Models\MessengerUser;

it('can create a messenger user', function () {
    $user = MessengerUser::factory()->create();

    expect($user->id)->toBeString()
        ->and($user->email)->not->toBeEmpty();
});

it('can create a message with a sender', function () {
    $sender = MessengerUser::factory()->create();
    $message = Message::factory()->create([
        'sender_type' => MessengerUser::class,
        'sender_id' => $sender->getKey(),
    ]);

    expect($message->sender->is($sender))->toBeTrue()
        ->and($message->body)->not->toBeEmpty();
});

it('can create a group and attach users', function () {
    $group = Group::factory()->create();
    $user = MessengerUser::factory()->create();

    $group->users()->attach($user->getKey(), ['user_type' => MessengerUser::class]);

    expect($group->users()->count())->toBe(1);
});

it('can register a device token via HasMessenger', function () {
    $user = MessengerUser::factory()->create();

    $token = $user->registerDeviceToken('fcm-token-abc', 'android');

    expect($token->token)->toBe('fcm-token-abc')
        ->and($token->platform)->toBe('android')
        ->and($token->last_seen_at)->not->toBeNull();
});

it('can mark a message as read via HasMessenger', function () {
    $user = MessengerUser::factory()->create();
    $message = Message::factory()->create();

    $user->markMessageRead($message);

    $receipt = MessageReceipt::where('message_id', $message->getKey())
        ->where('user_type', MessengerUser::class)
        ->where('user_id', $user->getKey())
        ->first();

    expect($receipt)->not->toBeNull()
        ->and($receipt->read_at)->not->toBeNull();
});

it('can create a device token via factory', function () {
    $token = DeviceToken::factory()->create();

    expect($token->id)->toBeString()
        ->and($token->token)->not->toBeEmpty();
});

it('tracks read and recipient counts on a message', function () {
    $sender = MessengerUser::factory()->create();
    $message = Message::factory()->create([
        'sender_type' => MessengerUser::class,
        'sender_id' => $sender->getKey(),
    ]);

    $userA = MessengerUser::factory()->create();
    $userB = MessengerUser::factory()->create();

    $userA->markMessageRead($message);
    MessageReceipt::create([
        'message_id' => $message->getKey(),
        'user_type' => MessengerUser::class,
        'user_id' => $userB->getKey(),
    ]);

    expect($message->recipientCount())->toBe(2)
        ->and($message->readCount())->toBe(1);
});
