<?php

namespace App;

use App\Models\Activity;

trait RecordActivity
{

    public $oldAttribute = [];
    


    public static function bootRecordActivity(){
        static::updating(function($model){
        $model->oldAttribute = $model->getOriginal();

        });
    
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id'=>($this->project ??$this)->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }
  
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
    public function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_diff($this->oldAttribute, $this->getAttributes()),
                'after' => $this->getChanges()
            ];
        }
    }
}
