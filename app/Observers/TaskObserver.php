<?php

namespace App\Observers;

use App\Models\Task;
use App\Notifications\TaskStatusUpdated;

class TaskObserver
{
    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->isDirty('status')) {
            $task->user->notify(new TaskStatusUpdated($task));
        }
    }
}
