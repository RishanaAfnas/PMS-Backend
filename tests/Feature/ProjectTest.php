<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     */
     use RefreshDatabase;

    public function test_admin_can_create_project()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'sanctum')
                         ->postJson('/api/projects', [
                             'title' => 'New Project',
                             'description' => 'Project description',
                             'start_date' => now()->toDateString(),
                             'end_date' => now()->addWeek()->toDateString(),
                         ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'New Project']);
    }
}
