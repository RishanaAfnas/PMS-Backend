<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    protected $model = \App\Models\Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['pending', 'in-progress', 'done']),
            'due_date' => $this->faker->dateTimeThisMonth()->format('Y-m-d'),
            'project_id' => Project::factory()->create()->id,   // ✅ ensure valid project ID
            'assigned_to' => User::factory()->create()->id,     // ✅ ensure valid user ID
            'created_by' => User::factory()->create()->id,      // ✅ ensure valid user ID

        ];
    }
}
