<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
   use RefreshDatabase;

    /** @test */
    public function user_can_add_comment_to_task()
    {
        // Create a user
        $user = User::factory()->create(['role' => 'user']);

        // Create a task
        $task = Task::factory()->create();

        // Act as the user and post a comment
        $response = $this->actingAs($user, 'sanctum')
                         ->postJson("/api/tasks/{$task->id}/comments", [
                             'body' => 'This is a comment.',
                         ]);

        // Assert that the response is correct
        $response->assertStatus(201)
                 ->assertJsonFragment(['body' => 'This is a comment.']);
    }
}
