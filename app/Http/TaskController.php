<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

   public function index(Request $request)
{
    // Фільтрація за статусом, пріоритетом та іншими параметрами
    $query = Task::query();

    if ($request->has('status')) {
        $query->where('status', $request->input('status'));
    }

    if ($request->has('priority_from')) {
        $query->where('priority', '>=', $request->input('priority_from'));
    }

    if ($request->has('priority_to')) {
        $query->where('priority', '<=', $request->input('priority_to'));
    }

    if ($request->has('title')) {
        $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
    }

    // Сортування за часом створення, часом виконання та пріоритетом
    if ($request->has('sort_by')) {
        if ($request->input('sort_by') === 'created_at') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->input('sort_by') === 'completed_at') {
            $query->orderBy('completed_at', 'asc');
        } elseif ($request->input('sort_by') === 'priority') {
            $query->orderBy('priority', 'asc');
        }
    }

    $tasks = $query->get();

    return response()->json(['tasks' => $tasks]);
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'in:todo,done',
        'priority' => 'integer|between:1,5',
        'parent_id' => 'exists:tasks,id',
    ]);

    $task = Task::create($validatedData);

    return response()->json(['task' => $task]);
}

public function show(Task $task)
{
    return response()->json(['task' => $task]);
}

public function update(Request $request, Task $task)
{
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'in:todo,done',
        'priority' => 'integer|between:1,5',
        'parent_id' => 'exists:tasks,id',
    ]);

    $task->update($validatedData);

    return response()->json(['task' => $task]);
}

public function destroy(Task $task)
{
    $task->delete();

    return response()->json(['message' => 'Task deleted']);
}

public function markAsDone(Task $task)
{
    $task->status = 'done';
    $task->completed_at = now();
    $task->save();

    return response()->json(['task' => $task]);
    }

    public function storeSubtask(Request $request, Task $task)
{
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'in:todo,done',
        'priority' => 'integer|between:1,5',
    ]);

    $subtask = $task->subtasks()->create($validatedData);

    return response()->json(['subtask' => $subtask]);
}

public function updateSubtask(Request $request, Task $task, Task $subtask)
{
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'in:todo,done',
        'priority' => 'integer|between:1,5',
    ]);

    $subtask->update($validatedData);

    return response()->json(['subtask' => $subtask]);
    }
}
