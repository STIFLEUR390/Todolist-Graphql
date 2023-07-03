<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $priority = [1, 2, 3];
        return [
            'title' => fake()->sentence(5),
            'description' => fake()->text(),
            'due_date' => fake()->dateTimeBetween('+10 days', '+1 months'),
            'priority' => rand(0, count($priority) -1),
            'completed' => fake()->boolean(50),
            'user_id' => User::all()->random(),
            'category_id' => Category::all()->random(),
        ];
    }
}
