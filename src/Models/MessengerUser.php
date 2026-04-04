<?php

namespace NettSite\Messenger\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use NettSite\Messenger\Contracts\MessengerAuthenticatable;
use NettSite\Messenger\Database\Factories\MessengerUserFactory;
use NettSite\Messenger\Enums\UserStatus;
use NettSite\Messenger\Traits\HasMessenger;

class MessengerUser extends Authenticatable implements FilamentUser, MessengerAuthenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasMessenger;
    use HasUuids;

    protected $table = 'messenger_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    /** @var array<string, mixed> */
    protected $attributes = [
        'status' => 'active',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'status' => UserStatus::class,
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isActive();
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::Active;
    }

    public function isPending(): bool
    {
        return $this->status === UserStatus::Pending;
    }

    public function isSuspended(): bool
    {
        return $this->status === UserStatus::Suspended;
    }

    protected static function newFactory(): MessengerUserFactory
    {
        return MessengerUserFactory::new();
    }
}
