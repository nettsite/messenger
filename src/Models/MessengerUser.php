<?php

namespace NettSite\Messenger\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NettSite\Messenger\Database\Factories\MessengerUserFactory;
use NettSite\Messenger\Traits\HasMessenger;

class MessengerUser extends Authenticatable
{
    use HasFactory;
    use HasMessenger;
    use HasUuids;

    protected $table = 'messenger_users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function newFactory(): MessengerUserFactory
    {
        return MessengerUserFactory::new();
    }
}
