# nettsite/messenger

This package provides push-based messaging from a Laravel admin backend to mobile app users via FCM (Firebase Cloud Messaging) with a polling fallback.

## Architecture

- **Direction**: Admin → User only. Users can reply but cannot initiate messages.
- **Delivery**: FCM HTTP v1 API (service account JSON auth) with polling fallback for non-GMS devices.
- **Auth**: Laravel Sanctum tokens for mobile API access.
- **Admin UI**: Dedicated Filament panel at `/messenger`.

## Namespace & Models

All classes live under `NettSite\Messenger`. Models are in `NettSite\Messenger\Models\`:

- `MessengerUser` — standalone user model (only used when `messenger.user_model` config is null)
- `Message` — `body`, `url` (nullable), `sender_type`, `sender_id`, `scheduled_at`, `sent_at`
- `MessageRecipient` — `recipient_type` enum(user, group, all), `recipient_id` (nullable for "all")
- `MessageReceipt` — `delivered_at`, `read_at` — one row per user per message
- `Group` / group pivot `messenger_group_users`
- `DeviceToken` — `token`, `platform` enum(android, ios), `last_seen_at`
- `Reply` — `message_id`, `user_id`, `body`

All models use `HasUuids` (UUID primary keys).

## Host App Integration

When using the host app's own User model, set `messenger.user_model` in config and add the `HasMessenger` trait:

```php
use NettSite\Messenger\Traits\HasMessenger;

class User extends Authenticatable
{
    use HasMessenger;
}
```

The trait adds: `messages()`, `groups()`, `deviceTokens()`, `registerDeviceToken()`, `markMessageRead()`.

## Sending Messages

Use the `Messenger` facade or inject `NettSite\Messenger\Messenger`:

```php
// Broadcast to all users
Messenger::broadcast(body: 'Hello everyone', url: null, recipientType: 'all', recipientId: null);

// Send to a group
Messenger::broadcast(body: 'Hello group', url: null, recipientType: 'group', recipientId: $groupId);

// Send to one user
Messenger::broadcast(body: 'Hello', url: null, recipientType: 'user', recipientId: $userId);

// Schedule a message
$message = Messenger::broadcast(...);
Messenger::schedule($message); // uses message->scheduled_at
```

## Mobile API Routes

All routes are prefixed `api/messenger` and protected by Sanctum where noted:

| Method | URI | Auth | Description |
|--------|-----|------|-------------|
| POST | `/auth/register` | — | Register device token, receive Sanctum token |
| DELETE | `/auth/logout` | Sanctum | Revoke token |
| GET | `/messages` | Sanctum | Paginated message list |
| POST | `/messages/{id}/read` | Sanctum | Mark message as read |
| GET | `/messages/poll` | Sanctum | Messages since last poll |
| POST | `/messages/{id}/replies` | Sanctum | Create reply |

## Config Keys

```php
// config/messenger.php
'user_model' => null,             // null = MessengerUser; else e.g. App\Models\User
'fcm.credentials' => '...',       // path to Firebase service account JSON
'fcm.project_id' => '...',        // Firebase project ID
'panel.id' => 'messenger',
'panel.path' => 'messenger',
```

## Fortify Conflict

If the host app uses Laravel Fortify, add to `FortifyServiceProvider::register()`:

```php
Fortify::ignoreRoutes();
```

## Database Tables

`messenger_users`, `messenger_device_tokens`, `messenger_groups`, `messenger_group_users`,
`messenger_messages`, `messenger_message_recipients`, `messenger_message_receipts`, `messenger_replies`

All foreign key columns referencing user models use `char(36)` (UUID-compatible).
