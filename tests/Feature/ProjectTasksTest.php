<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Database\Factories\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_project_can_have_tasks()
    {
        $this->signIn();
        // $project =  Project::factory()->create(['owner_id'=>auth()->id()]);
        $project =  Project::factory()->raw();
        $project = auth()->user()->projects()->create($project);
        $this->post($project->path() . '/tasks', ['body' => 'Test task']);
        $this->get($project->path())->assertSee('Test task');
    }
    public function test_guests_cannot_add_tasks_to_projects()
    {
        $project = Project::factory()->create();
        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }
    public function test_a_task_can_be_updated()
    {
        $project = Project::factory()->withTasks(1)->create();
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed'
            ]);
        $this->assertDatabaseHas('tasks', ['body' => 'changed']);
    }
    public function test_a_task_can_be_completed()
    {
        $project = Project::factory()->withTasks(1)->create();
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }
     public function test_a_task_can_be_marked_as_incompleted()
    {
        $project = Project::factory()->withTasks(1)->create();
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);
             $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => false
            ]);
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }
    public function test_only_the_owner_of_the_project_may_add_tasks()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }
    public function test_only_the_owner_of_the_project_may_update_a_tasks()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $task = $project->addTasks('Test task');
        $this->patch($task->path(), ['body' => 'changed'])
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }
    public function test_a_tasks_requires_a_body()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(Project::factory()->raw());
        $attributes = Task::factory()->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
     public function test_a_project_can_invite_a_user(): void
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $project->invite($user);
        $this->assertTrue($project->members->contains($user));
    
    }
}
