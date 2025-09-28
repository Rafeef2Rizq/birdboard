<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    public function test_guests_cannot_manage_projects()
    {
        $project = Project::factory()->create();
        $this->get($project->path())->assertRedirect('login');
        $this->get(uri: '/projects')->assertRedirect('login');
        $this->get(uri: '/projects/create')->assertRedirect('login');
                $this->get(uri: '/projects/edit')->assertRedirect('login');

        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }


    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        // $user = User::factory()->create();
        $this->get('/projects/create')->assertStatus(200);
        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'notes' => 'General notes here'
        ];
        // $this->actingAs($user) 
        //      ->post('/projects', $attributes);
        // $attributes = [
        //     'title' => $attributes['title'],
        //     'description' => $attributes['description'],
        //     'owner_id' => $user->id,
        // ];
        $response = $this->post('/projects', $attributes);
        $project = Project::where($attributes)->first();
        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())->assertSee($attributes['title']);
    }

    public function test_project_requires_a_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
    public function test_a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }
    public function test_a_user_can_update_a_project(){
        $this->signIn();
        $this->withoutExceptionHandling();
        $project =  Project::factory()->create(['owner_id' => auth()->id()]);
        $this->patch($project->path(),['notes'=>'changed','title'=>'changed',
        'description'=>'changed'])
        ->assertRedirect($project->path());
        $this->get($project->path().'/edit')->assertOk();
        $this->assertDatabaseHas('projects',['title'=>'changed',
        'description'=>'changed','notes'=>'changed']);
    }
     public function test_a_user_can_update_g_general_a_project(){
        $this->signIn();
        $this->withoutExceptionHandling();
        $project =  Project::factory()->create(['owner_id' => auth()->id()]);
        $this->patch($project->path(),['notes'=>'changed'])
        ->assertRedirect($project->path());
        $this->get($project->path().'/edit')->assertOk();
        $this->assertDatabaseHas('projects',['notes'=>'changed']);
    }
    public function test_a_user_can_view_their_project()
    {
        $this->signIn();
        $project =  Project::factory()->create(['owner_id' => auth()->id()]);
        $this->get($project->path())->assertSee( $project->title);
            // ->assertSee(value: $project->description);
    }
    public function test_an_authenticated_user_cannot_view_the_projects_of_other()
    {
        $this->signIn();
        // $this->withoutExceptionHandling();
        $project =  Project::factory()->create();
        $this->get($project->path())->assertStatus(403);
    }
       public function test_an_authenticated_user_cannot_update_the_projects_of_other()
    {
        $this->signIn();
        $project =  Project::factory()->create();
        $this->patch($project->path(),[])->assertStatus(403);
    }
}
