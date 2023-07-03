<?php

namespace App\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class TaskFilterEnumType extends EnumType
{
    protected $attributes = [
        'name' => 'TaskFilter',
        'description' => 'Filters for tasks',
        'values' => [
            'ALL' => 'all',
            'COMPLETED' => 'completed',
            'INCOMPLETE' => 'incomplete',
        ],
    ];
}
