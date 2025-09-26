<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Services\TaskAssignmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskAssignedNotification;

class TaskAssignmentServiceTest extends TestCase
{
    /**
     * A basic unit test example
     */
 use RefreshDatabase;

    /** @test */
    public function test_it_assigns_task_to_a_valid_user()
    {
        Notification::fake(); // <-- add this here
        $user = User::factory()->create(['role' => 'user']);
        $task = Task::factory()->create();

        $service = new TaskAssignmentService();
        $assignedTask = $service->assignTask($task, $user);

        $this->assertEquals($user->id, $assignedTask->assigned_to);
        Notification::assertSentTo(
            [$user],
            TaskAssignedNotification::class
        );
    }
    

    /** @test */
    public function test_it_throws_exception_for_invalid_user_role()
    {
        $this->expectException(\Exception::class);

        $user = User::factory()->create(['role' => 'admin']); // invalid role for assignment
        $task = Task::factory()->create();

        $service = new TaskAssignmentService();
        $service->assignTask($task, $user);
    }
}
