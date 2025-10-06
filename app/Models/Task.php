<?php

namespace App\Models;

use App\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory,RecordActivity;

    protected $guarded = [];

    protected $touches = ['project'];
    protected $casts = [
        'completed' => 'boolean',
    ];
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::created(function ($task) {
    //         $task->recordActivity('created_task');
    //     });
    // }

    public function complete()
    {
       $this->update(['completed' => true]);
        $this->recordActivity('completed_task');
    }
    public function incomplete()
    {
        $this->update(['completed' => false]);
         $this->recordActivity('incompleted_task');

    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
     
  
}
