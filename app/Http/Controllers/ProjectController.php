<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   public function index()
   {
      $projects = auth()->user()->projects()->orderBy('updated_at', 'desc')->get();
      return view('projects.index',  compact('projects'));
   }
   public function create()
   {
      return view('projects.create');
   }
   public function show(Project $project)
   {
      if (auth()->id() != $project->owner_id) {
         abort(403);
      }
      return view('projects.show', data: compact('project'));
   }
   public function store(Request $request)
   {
      //validate

      //  $attributes['owner_id'] = auth()->id();
      $project = auth()->user()->projects()->create($this->validateRequest());

      //persist
      //redirect
      return redirect($project->path());
   }
   public function edit(Project $project)
   {
      return view('projects.edit', compact('project'));
   }
   public function update(Project $project, UpdateProjectRequest $request)
   {
      // if (auth()->id() != $project->owner_id) {
      //    abort(403);
      // }
      //validate
      $project->update($request->validated());
      return redirect($project->path());
   }

   protected function validateRequest()
   {
     return request()->validate(
         [
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
         ]
      );
   }
}
