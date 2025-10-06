<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectInvatationsController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);
     $validatedData=   request()->validate(
            [
                'email' => ['exists:users,email', 'required']
            ],
            ['email.exists' => 'The user are inviting must have a birdboard account']
        );
        $user = User::whereEmail(request('email'))->first();
        $project->invite($user);
        return redirect($project->path())->withErrors($validatedData, 'invatations');
    }
}
