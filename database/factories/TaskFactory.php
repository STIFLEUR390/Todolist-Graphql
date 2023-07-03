<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
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
        $reminder_date = fake()->dateTimeBetween('+10 days', '+1 months');
        return [
            'title' => fake()->sentence(5),
            'description' => fake()->text(),
            'due_date' => Carbon::parse($reminder_date)->addDays(20),
            'priority' => $priority[rand(0, count($priority) -1)],
            'completed' => fake()->boolean(50),
            'reminder_date' => $reminder_date,
            'user_id' => User::all()->random(),
            'category_id' => Category::all()->random(),
        ];
    }
}
