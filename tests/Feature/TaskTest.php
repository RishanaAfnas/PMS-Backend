<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function manager_can_update_task_status()
    {
        // Create a manager user
        $manager = User::factory()->create(['role' => 'manager']);

        // Create a task
        $task = Task::factory()->create();

        // Act as the manager using Sanctum
        $response = $this->actingAs($manager, 'sanctum')
                         ->putJson("/api/tasks/{$task->id}", [
                             'status' => 'done',
                         ]);

        // Assert response
        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'done']);
    }
}
