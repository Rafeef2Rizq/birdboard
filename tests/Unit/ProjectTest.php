<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_it_has_a_path(): void
    {
        $project =  Project::factory()->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }
    public function test_it_belongs_to_an_owner()
    {
        $project =  Project::factory()->create();
        $this->assertInstanceOf(User::class, $project->owner);
    }
    //here
    public function test_it_can_add_a_task()
    {
        $project =  Project::factory()->create();
        $task = $project->addTasks('Test task');
        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
