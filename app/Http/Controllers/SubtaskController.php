<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtask;
use App\Models\Task;

class SubtaskController extends Controller
{
    public function index(Subtask $subtask, Request $request, $taskId)
{
     $query = Subtask::query();

    if ($request->has('status')) {
        $query->where('status', $request->input('status'));
    }

     if ($request->has('priority_from') && is_numeric($request->input('priority_from'))) {
        $query->where('priority', '>=', $request->input('priority_from'));
    }

    if ($request->has('priority_to') && is_numeric($request->input('priority_to'))) {
        $query->where('priority', '<=', $request->input('priority_to'));
    }

    if ($request->has('title')) {
        $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
    }

    if ($request->has('sort_by')) {
        if ($request->input('sort_by') === 'created_at') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->input('sort_by') === 'completed_at') {
            $query->orderBy('completed_at', 'asc');
        } elseif ($request->input('sort_by') === 'priority') {
            $query->orderBy('priority', 'asc');
        }
    }
     $query->where('parent_id', $taskId);
    $subtasks = $query->get();
    $task = Task::find($taskId);

     return view('subtask.index', ['subtasks' => $subtasks, 'taskId' => $taskId, 'task' => $task]);
}

public function create(Task $task)
{
     $subtasks = $task->subtasks;

     return view('subtask.create', compact('task', 'subtasks'));
  
}

    public function store(Request $request, Task $task)
{
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'in:todo,done',
        'priority' => 'integer|between:1,5',
    ]);

    $validatedData['parent_id'] = $task->id;

    $subtask = Subtask::create($validatedData);

    return redirect()->route('tasks.subtasks.index', ['task' => $task->id])
        ->with('success', 'Підзадачу створено успішно');
}

public function update(Request $request, Subtask $subtask)
{
    // Валідація даних з форми редагування
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'in:todo,done',
        'priority' => 'integer|between:1,5',
        'parent_id' => 'exists:tasks,id',
    ]);

    // Оновлення даних підзадачі
    $subtask->update($validatedData);

    // Повернення користувача на сторінку завдання або іншу потрібну сторінку
    return redirect()->route('tasks.subtasks.index', ['task' => $subtask->parent_id])->with('success', 'Підзадачу редаговано успішно');
}

public function destroy($id)
{
            $subtask = Subtask::findOrFail($id);
    $subtask->delete();

    return redirect()->route('tasks.subtasks.index', ['task' => $subtask->parent_id])->with('success', 'Підзадачу видалено успішно');

}

public function edit($id)
{
    $subtask = SubTask::findOrFail($id);
    return view('subtask.edit', compact('subtask'));
    }

public function markAsDone($task, $subtask)
{
    $subtask = Subtask::findOrFail($subtask);
    $subtask->update(['status' => 'done']);
    return redirect()->back()->with('success', 'Підзадачу відзначено як виконану');
}



    public function storeSubtask(Request $request, Subtask $subtask)
{
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'in:todo,done',
        'priority' => 'integer|between:1,5',
    ]);

    $subtask = $task->subtasks()->create($validatedData);

    return redirect()->route('tasks.subtasks.index', ['task' => $subtask->parent_id])->with('success', 'Успішно');
}

}
