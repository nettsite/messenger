<?php

namespace NettSite\Messenger\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use NettSite\Messenger\Enums\UserStatus;

/**
 * @property string $id
 * @property string $user_type
 * @property string $user_id
 * @property UserStatus $status
 * @property Carbon|null $enrolled_at
 */
class MessengerEnrollment extends Model
{
    use HasUuids;

    protected $table = 'messenger_enrollments';

    protected $fillable = [
        'user_type',
        'user_id',
        'status',
        'enrolled_at',
    ];

    protected $casts = [
        'status' => UserStatus::class,
        'enrolled_at' => 'datetime',
    ];

    public function user(): MorphTo
    {
        return $this->morphTo();
    }
}
