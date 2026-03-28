<?php

namespace NettSite\Messenger\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageRecipient extends Model
{
    use HasUuids;

    protected $table = 'messenger_message_recipients';

    protected $fillable = [
        'message_id',
        'recipient_type',
        'recipient_id',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
