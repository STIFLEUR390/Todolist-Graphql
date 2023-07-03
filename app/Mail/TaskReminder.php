<?php

namespace App\Mail;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $user;
    public $date;
    public $time;
    public $description;
    public $diff;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($id)
    {
        $task = Task::with('user')->whereId($id)->firstOrFail();
        $this->title = $task->title;
        $this->user = $task->user->name;
        $this->description = $task->description;
        $date = Carbon::parse($task->due_date);
        $now = Carbon::now();
//        $this->diff = $date->diffInDays($now);
        $this->diff = $now->diffInDays($date);
        $this->date = $date->format('Y-m-d');
        $this->time = $date->format("H:i:s");
        $this->url = env("FRONTEND_URL") ?? url();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __("Task Reminder"),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tasks.reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
