<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      User::factory()->create([
            'name' => 'Admin1',
            'email' => 'admin1@example.com',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Admin2',
            'email' => 'admin2@example.com',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Admin3',
            'email' => 'admin3@example.com',
            'role' => 'admin',
        ]);

        // 3 Managers
        User::factory()->create([
            'name' => 'Manager1',
            'email' => 'manager1@example.com',
            'role' => 'manager',
        ]);
        User::factory()->create([
            'name' => 'Manager2',
            'email' => 'manager2@example.com',
            'role' => 'manager',
        ]);
        User::factory()->create([
            'name' => 'Manager3',
            'email' => 'manager3@example.com',
            'role' => 'manager',
        ]);

        // 5 Regular Users
        User::factory()->count(5)->create(); // role defaults to 'user'

        // ---- PROJECTS ----
        Project::factory()->count(5)->create();

        // ---- TASKS ----
        Task::factory()->count(10)->create();

        // ---- COMMENTS ----
        Comment::factory()->count(10)->create();
    }
}
