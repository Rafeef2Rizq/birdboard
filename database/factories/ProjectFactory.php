<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'title'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph,
             'owner_id' => \App\Models\User::factory(),
        ];
    }
      public function withTasks(int $count = 1)
    {
        return $this->has(Task::factory()->count($count), 'tasks');
    }
}
