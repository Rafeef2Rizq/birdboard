<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
       $this->authorize('update',$project);
        request()->validate(['body' => 'required']);
        $project->addTasks(request('body'));
        return redirect($project->path())->with('success', 'Taks added successfully');
    }
    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

    $attributes= request()->validate(['body' =>['min:5','required'] ]);

        $task->update( $attributes);
        
       request('completed')? $task->complete() : $task->incomplete();
      
        return redirect($project->path())->withErrors($attributes, 'project');
    }
}
