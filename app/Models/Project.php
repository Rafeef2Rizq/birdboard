<?php

namespace App\Models;

use App\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, RecordActivity;
    protected $guarded = [];

    public function path(): string
    {
        return '/projects/' . $this->id;
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function addTasks($body)
    {
        return $this->tasks()->create(compact('body'));
    }


    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }
    public function invite(User $user)
    {
        if ($this->members->contains($user)) {
            return;
        }
        return $this->members()->attach($user);
    }
    public function members()
    {
        //is it true that a project  can have many members
        //and also a member can have many projects
        return   $this->belongsToMany(User::class, 'project_members')
            ->withTimestamps();
    }
    function gravatarUrl($email, $size = 80)
    {
        $email = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$email}?s={$size}";
    }
}
