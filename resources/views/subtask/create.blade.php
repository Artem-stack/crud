@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Створити підзадачу</h2>
        <form method="POST" action="{{ route('tasks.subtasks.store', ['task' => $task->id]) }}">
            @csrf
            <div class="form-group">
                <label for="title">Заголовок:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Опис:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="status">Статус:</label>
                <select class="form-control" id="status" name="status">
                    <option value="todo">Todo</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <div class="form-group">
                <label for="priority">Пріоритет:</label>
                <input type="number" class="form-control" id="priority" name="priority" min="1" max="5" required>
            </div>
            <button type="submit" class="btn btn-primary">Створити</button>
        </form>
    </div>
@endsection
