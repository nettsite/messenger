<?php

namespace NettSite\Messenger\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reply extends Model
{
    use HasUuids;

    protected $table = 'messenger_replies';

    protected $fillable = [
        'message_id',
        'user_type',
        'user_id',
        'body',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function author(): MorphTo
    {
        return $this->morphTo('user');
    }
}
