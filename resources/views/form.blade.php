<form method="POST" action="{{ route('tasks.store') }}" class="mt-3">
    @csrf
    <div class="form-group">
        <label for="title">Заголовок</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="description">Опис</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <div class="form-group">
        <label for="status">Статус</label>
        <select name="status" class="form-control">
            <option value="todo">Todo</option>
            <option value="done">Done</option>
        </select>
    </div>
    <div class="form-group">
        <label for="priority">Пріоритет</label>
        <input type="number" class="form-control" id="priority" name="priority">
    </div>
    <button type="submit" class="btn btn-primary">Зберегти</button>
</form>