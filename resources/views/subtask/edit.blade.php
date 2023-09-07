@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Task</h1>
        
        <form method="POST" action="{{ route('subtasks.update', ['subtask' => $subtask->id]) }}">
            @csrf
            @method('PUT') 
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $subtask->title }}">
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $subtask->description }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="todo" {{ $subtask->status === 'todo' ? 'selected' : '' }}>To Do</option>
                    <option value="done" {{ $subtask->status === 'done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="priority">Priority</label>
                <input type="number" name="priority" id="priority" class="form-control" value="{{ $subtask->priority }}">
            </div>
            
            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
@endsection