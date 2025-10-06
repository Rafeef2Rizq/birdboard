<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectTasksController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    function test_non_owners_may_not_invite_a_user()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $assertInvitationForbidden = function () use ($project, $user) {
            $this->actingAs($user)
                ->post($project->path() . '/invitations')
                ->assertStatus(403);
        };
        $assertInvitationForbidden();
        $project->invite($user);
        $assertInvitationForbidden();
    }
    function test_a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = Project::factory()->create();
        $userToInvite = User::factory()->create();
        $this->actingAs($project->owner)->post(
            $project->path() . '/invitations',
            ['email' => $userToInvite->email]
        )->assertRedirect($project->path());
        $this->assertTrue($project->members->contains($userToInvite));
    }
    public function test_email_address_must_acssociated_a_valid_bireboard_account()
    {
        $project = Project::factory()->create();
        $this->actingAs($project->owner)->post(
            $project->path() . '/invitations',
            ['email' => 'none@gmail.com']
        )->assertSessionHasErrors(['email' => 'The user are inviting must have a birdboard account']
    );
    }
    public function test_ivited_users_may_update_project_details(): void
    {
        //given i have a project
        //and the owner of the project invites another user
        //then,that new user will  have perssion to add new tasks
        $project = Project::factory()->create();
        $newUser = User::factory()->create();
        $project->invite($newUser);

        $this->signIn($newUser);
        $response = $this->post(action([ProjectTasksController::class, 'store'], $project), $task = ['body' => 'foo task']);
        $this->assertDatabaseHas('tasks', $task);
        //    $response->assertStatus(201);
    }
}
