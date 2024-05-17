<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    private Task $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Task Status Updated')
                    ->greeting('Hello ' . $this->task->user->name . '!')
                    ->line('The status of your task ' . $this->task->title . ' (ID: ' . $this->task->id . ') has been updated to ' . $this->task->status . '.')
                    ->action('View Task', url('/'))
                    ->line('Thank you for using our application!');
    }
}
