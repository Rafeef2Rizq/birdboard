<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Gravatar;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   public function index()
   {
      // Projects where user is owner OR member
      $projects = Project::where('owner_id', auth()->id())
         ->orWhereHas('members', function ($query) {
            $query->where('user_id', auth()->id());
         })
         ->orderBy('updated_at', 'desc')
         ->get();

      return view('projects.index', compact('projects'));
   }

   public function create()
   {
      return view('projects.create');
   }
   public function show(Project $project)
   {
      $this->authorize('update', $project);

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
      $this->authorize('update', $project);
      //validate
      $project->update($request->validated());
      return redirect($project->path());
   }
   public function destroy(Project $project)
   {
      $this->authorize('manage', $project);
      $project->delete();
      return redirect('/projects');
   }

   protected function validateRequest()
   {
      return request()->validate(
         [
            'title' => 'sometimes|required',
            'description' => 'sometimes|required|min:5',
            'notes' => 'nullable|min:5'
         ]
      );
   }



}
