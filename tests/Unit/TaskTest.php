<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Database\Factories\TaskFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_it_belongs_to_a_project(){
                 $task=Task::factory()->create();
$this->assertInstanceOf(Project::class, $task->project);
    }
    
     public function test_it_has_a_path(): void
    {
         $task=Task::factory()->create();

         $this->assertEquals('/projects/'.$task->project->id.'/tasks/'.$task->id, $task->path);
    }
    function test_it_can_be_completed(){
        $task=Task::factory()->create();
         $this->assertFalse($task->completed);
        $task->complete();
        $this->assertTrue($task->fresh()->completed);
    }
       function test_it_can_be_marked_as_incompleted(){
        $task=Task::factory()->create(['completed'=>true]);
         $this->assertFalse($task->completed);
        $task->incomplete();
        $this->assertTrue($task->fresh()->completed);
    }
}
