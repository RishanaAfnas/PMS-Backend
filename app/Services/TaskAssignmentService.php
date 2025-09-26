<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Exception;

class TaskAssignmentService
{
    public function assignTask(Task $task, User $user): Task
    {
        if ($user->role !== 'user' && $user->role !== 'manager') {
            throw new \Exception("User cannot be assigned tasks");
        }

        $task->assigned_to = $user->id;
        $task->save();

        //send Notification
        $user->notify(new TaskAssignedNotification($task));
        return $task;
    }
}
