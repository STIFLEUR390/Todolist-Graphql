<?php

namespace App\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class TaskPriorityEnum extends EnumType
{
    protected $attributes = [
        'name' => 'TaskPriority',
        'description' => 'The priority level of a task',
        'values' => [
            'LOW' => '1',
            'MEDIUM' => '2',
            'HIGH' => '3',
        ],
    ];
}
