<?php

namespace NettSite\Messenger\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NettSite\Messenger\Models\Group;

/**
 * @extends Factory<Group>
 */
class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
        ];
    }
}
