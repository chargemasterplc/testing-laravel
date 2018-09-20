<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

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
        $this->tasks = User::find($this->user->id)->tasks;

        return view('tasks.tasks')->with('tasks', $this->tasks);
    }
}
