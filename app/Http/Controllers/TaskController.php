<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private $user;
    private $tasks;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->user = Auth::user();

        $this->tasks = $this->user->tasks;

        $data = [
            'tasks' => $this->tasks,
            'incompleteTasks' => $this->getIncompleteTasks(),
        ];

        return view('tasks.tasks')->with('data', $data);
    }

    public function create(Request $request)
    {
        $task = Task::create([
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);

        return redirect('tasks');
    }

    private function getIncompleteTasks()
    {
        return $this->tasks->filter(function($task) {
            return $task->completed === 0;
        });
    }
}
