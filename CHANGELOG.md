# Changelog

All notable changes to `nettsite/messenger` will be documented in this file.

## [1.1.1] - 2026-04-06

### Added

- **Approval mode is back** — `MESSENGER_REGISTRATION_MODE=approval` works again. Registering returns HTTP 202 and the user waits for admin approval before they can log in.
- **`messenger_enrollments` table** — a morph table that tracks each user's messenger status (`active`, `pending`, `suspended`) separately from the host app's User model. The package never touches your `users` table to record status.
- **`UserStatus` enum** — `Active`, `Pending`, `Suspended`.
- **First-login detection** — when a host-app user (created outside the messenger registration flow) logs in for the first time, the `login` endpoint now applies the current registration mode rules and creates an enrollment record automatically. Previously these users were silently allowed in regardless of mode.
- **`messenger:install` now runs `install:api`** — if `routes/api.php` is absent, the installer calls `php artisan install:api` on your behalf, which sets up Sanctum and the `personal_access_tokens` table.

### Fixed

- `RegisterUserRequest` had a hardcoded `unique:users,email` rule that ignored the configured `messenger.user_model` table. The uniqueness check is now handled in the controller using the correct model.

---

## [1.1.0] - 2026-04-05

### Breaking changes

- **Removed `MessengerUser` model.** The package no longer ships its own users table or authentication model. Your application's existing User model is used exclusively. Set `MESSENGER_USER_MODEL` in your `.env` (defaults to `App\Models\User`).
- **Removed `RegistrationMode::Approval`.** The `approval` registration mode depended on the now-removed `UserStatus` enum. Only `open` and `closed` are valid values for `MESSENGER_REGISTRATION_MODE`.
- **`MessengerPanelProvider` is no longer auto-registered.** The standalone panel is opt-in — add it manually to `bootstrap/providers.php` if needed. The recommended integration path is `MessengerPlugin` (see below).

### Added

- **`MessengerPlugin`** — integrates Messenger into your existing Filament panel with a single line:
  ```php
  ->plugin(MessengerPlugin::make())
  ```
  Adds Messages and Groups resources to whichever panel you choose.

- **`php artisan messenger:install`** — guided setup command that publishes config and migrations, optionally runs migrations, checks for the `HasMessenger` trait on your User model, and prints the plugin registration snippet.

### Migration guide

1. Add `HasMessenger`, `HasApiTokens`, and `implements MessengerAuthenticatable` to your User model.
2. Add `->plugin(MessengerPlugin::make())` to your Filament panel provider.
3. Remove `MESSENGER_REGISTRATION_MODE=approval` from your `.env` if set — use `open` or `closed`.
4. Remove any reference to `MessengerUser` or `UserStatus` in your application code.
5. Drop the `messenger_users` table if you ran migrations from a previous version:
   ```sql
   DROP TABLE IF EXISTS messenger_users;
   ```

---

## [1.0.2] - 2026-04-01

- Added server-configured polling interval for web clients via `GET /api/messenger/config`.

## [1.0.1] - 2026-03-30

- Added message view page, reply thread display, and admin respond flow in Filament.

## [1.0.0] - 2026-03-28

- Initial release.
- `MessengerUser` model with open / approval / closed registration modes.
- FCM push delivery with polling fallback.
- Filament admin panel for messages, groups, and user management.
- Sanctum-based mobile API (register, login, device tokens, messages, replies).
