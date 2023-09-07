@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список завдань</h1>

        <!-- Фільтри та сортування -->
        <form method="GET">
            <div class="form-row">
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">Всі статуси</option>
                        <option value="todo">Тільки Todo</option>
                        <option value="done">Тільки Done</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="priority_from" class="form-control" placeholder="Пріоритет від">
                </div>
                <div class="col-md-3">
                    <input type="number" name="priority_to" class="form-control" placeholder="Пріоритет до">
                </div>
                <div class="col-md-3">
                    <input type="text" name="title" class="form-control" placeholder="Пошук за заголовком">
                </div>
                 <th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at']) }}" class="btn btn-link btn-sm" style="text-decoration: none;">Дата створення</a>
</th>
<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'completed_at']) }}" class="btn btn-link btn-sm" style="text-decoration: none;">Дата виконання</a>
</th>
<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'priority']) }}" class="btn btn-link btn-sm" style="text-decoration: none;">Пріоритет</a>
</th>
               <div class="col-md-3 mt-2"> 
            <button type="submit" class="btn btn-primary">Фільтрувати</button>
        </div>
          <div class="col-md-3 mt-2">
            <a href="{{ route('home.index') }}" class="btn btn-secondary">Зняти фільтри</a>
        </div>
        <div class="col-md-3 mt-2">
            <a href="{{ route('home.create') }}" class="btn btn-success">Створити завдання</a>
        </div>

        </form>

        <!-- Таблиця зі списком завдань -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Заголовок</th>
                    <th>Статус</th>
                    <th>Пріоритет</th>
                    <th>Дата створення</th>
                    <th>Дата виконання</th>
                    <th>Дії</th>
                    <th>Підзадачі</th>
                </tr>
            </thead>
            <tbody>
                <!-- Виведення завдань зі змінної $tasks -->
              @foreach ($tasks as $task)
    <tr>
        <td>{{ $task->title }}</td>
        <td>{{ $task->status }}</td>
        <td>{{ $task->priority }}</td>
        <td>{{ $task->created_at }}</td>
        <td>{{ $task->completed_at }}</td>
        <td>
            <a href="{{ route('home.edit', ['home' => $task]) }}" class="btn btn-primary">Редагувати</a>

            <!-- Форма видалення завдання -->
            <form method="POST" action="{{ route('home.destroy', ['home' => $task->id]) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Видалити</button>
            </form>

            <!-- Посилання на відзначення як виконане -->
         @if ($task->status === 'todo')
    <form method="POST" action="{{ route('home.markAsDone', ['task' => $task->id]) }}">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-success">Відзначити виконаним</button>
    </form>
@else
    <button class="btn btn-success" disabled>Відзначити як виконане</button>
@endif
        </td>
        <td>
            <a href="{{ route('tasks.subtasks.index', ['task' => $task->id]) }}" class="btn btn-primary">Підзадачі</a>
        </td>
    </tr>
@endforeach
            </tbody>
        </table>
    </div>
@endsection