<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;


    /**
     * A basic unit test example.
     */
    public function test_a_user_has_projects(): void
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function test_a_user_has_accessible_projects()
    {

        $rana = User::factory()->create();  
        $this->actingAs($rana);
        $project = Project::factory()->create(['owner_id' => $rana->id]);

        $this->assertCount(1, $rana->accessibleProjects());
        $Ahmed=User::factory()->create();  
         $Ali=User::factory()->create();  
        $project = Project::factory()->create(['owner_id' => $Ahmed->id])->invite($Ali);
        $this->assertCount(1, $rana->accessibleProjects());

    }
}
