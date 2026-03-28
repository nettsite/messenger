<?php

namespace NettSite\Messenger\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use NettSite\Messenger\Database\Factories\GroupFactory;

class Group extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'messenger_groups';

    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): GroupFactory
    {
        return GroupFactory::new();
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(MessengerUser::class, 'user', 'messenger_group_users');
    }
}
