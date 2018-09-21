@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-6">Dashboard</h1>
            <p class="lead">Remaining Todos: {{ count($data['incompleteTasks']) }}</p>
            <form class="col-6" action="/tasks" method="POST">
                @csrf
                <div class="form-group">
                    <label for="body"></label>
                    <input id="body" class="form-control" type="text" name="body" placeholder="Do the shopping">
                </div>
                <button type="submit" class="btn btn-primary">New Todo</button>
            </form>
        </div>
    </div>
    <div class="container">
        <div id="tasks" class="row justify-content-center">
            @foreach ($data['tasks'] as $task)
                <div class="col-4">
                    <div class="card {{ $task->completed ? 'bg-success' : 'bg-warning' }}">
                        <div class="card-header">
                            {{ $task->created_at }}
                        </div>
                        <div class="card-body">
                            {{ $task->body }}
                        </div>
                        @if (!$task->completed)
                            <form action="/tasks/complete/{{$task->id}}" method="POST">
                                @csrf
                                <input type="submit" class="btn btn-success" value="Complete"/>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


