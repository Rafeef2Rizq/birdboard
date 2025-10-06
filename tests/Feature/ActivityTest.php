<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Database\Factories\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_has_a_user(): void
    {
       $user=$this->signIn();
        $project=ProjectFactory::ownedBy($user)->create();
        $this->assertEquals($user->id,$project->activity->first()->user->id);


 
    }
}
