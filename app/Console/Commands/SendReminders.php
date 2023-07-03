<?php

namespace App\Console\Commands;

use App\Mail\TaskReminder;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send task reminders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::with(['user'])->whereNotNull('reminder_date')
            ->where('reminder_date', '<=', now())
//            ->where('reminder_date', '>=', now())
            ->where('completed', false)
            ->get();

        foreach ($tasks as $task) {
            Mail::to($task->user)->send(new TaskReminder($task->id));
            // Envoyer le rappel par email, SMS, notification, etc.
        }
    }
}
