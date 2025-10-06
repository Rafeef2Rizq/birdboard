<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
  use RefreshDatabase;
  function test_creating_a_project()
  {
    $project = Project::factory()->create();
    $this->assertCount(1, $project->activity);
     tap($project->activity->last(),function($activity) {
    $this->assertEquals('created', $activity->description);
    $this->assertNull($activity->changes);

    });
  }
  function test_updating_a_project()
  {
    $project = Project::factory()->create();
    $originalTitle=$project->title;
    $project->update(['title' => 'changed']);
    $this->assertCount(2, $project->activity);
    tap($project->activity->last(),function($activity) use($originalTitle){
    $this->assertEquals('updated', $activity->description);

    });

  }
  function test_createing_a_new_task()
  {
    $project = Project::factory()->create();
    $project->addTasks('Some tasks');
    $this->assertCount(2, $project->activity);
    tap($project->activity->last(), function ($activity) {
      $this->assertEquals('created_task', $activity->description);
      $this->assertInstanceOf(Task::class, $activity->subject);
      $this->assertEquals('Some tasks', $activity->subject->body);
    });

    // $this->assertEquals('created',$project->activity[0]->description);
  }
  function test_completeing_a_task()
  {
    $project = Project::factory()->withTasks(1)->create();

    $this->assertCount(1, $project->tasks);

    $this->actingAs($project->owner)
      ->patch($project->tasks[0]->path(), [
        'body' => 'footbar',
        'completed' => true
      ]);

    $this->assertCount(3, $project->activity);
    tap($project->activity->last(), function ($activity) {
      $this->assertEquals('completed_task', $activity->description);
      $this->assertEquals('created_task', $activity->description);
      $this->assertInstanceOf(Task::class, $activity->subject);
    });
  }

  function test_incompleteing_a_task()
  {
    $project = Project::factory()->withTasks(1)->create();

    $this->assertCount(1, $project->tasks);

    $this->actingAs($project->owner)
      ->patch($project->tasks[0]->path(), [
        'body' => 'footbar',
        'completed' => true
      ]);
    $this->assertCount(3, $project->activity);

    $this->patch($project->tasks[0]->path(), [
      'body' => 'footbar',
      'completed' => false
    ]);
    $project->refresh();
    $this->assertCount(4, $project->activity);

    $this->assertEquals('incompleted_task', $project->activity->last()->description);
  }
  function deleting_a_task()
  {
    $project = Project::factory()->withTasks(1)->create();
    $project->tasks[0]->delete();
    $this->assertCount(3, $project->activity);
  }
}
