<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['body', 'completed'];

    const TASK_COMPLETE = 1;

    private $completed;

    public function isComplete()
    {
        return $this->completed === self::TASK_COMPLETE;
    }

    public function complete()
    {
        $this->completed = self::TASK_COMPLETE;
    }
}
