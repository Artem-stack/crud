<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
public function index(Request $request)
{
    $query = Task::query();

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
    $tasks = $query->where('user_id', Auth::user()->id)->get();

    return view('index', ['tasks' => $tasks]);
}

public function create()
{
    return view('create');
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

    // Додайте user_id до створеного завдання
    $validatedData['user_id'] = Auth::user()->id;

    $task = Task::create($validatedData);

    return redirect()->route('home.index')->with('success', 'Завдання створено');
}

public function show(Task $task)
{
    return response()->json(['task' => $task]);
}

public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);

    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'in:todo,done',
        'priority' => 'integer|between:1,5',
        'parent_id' => 'exists:tasks,id',
    ]);

    $task->update($validatedData);

    return redirect()->route('home.index')->with('success', 'Завдання оновлено');
}

public function destroy($id)
{
    $task = Task::findOrFail($id);
    
    if ($task->status !== 'done') {
        $task->delete();
        return redirect()->route('home.index')->with('success', 'Завдання видалено');
    } else {
        return redirect()->route('home.index')->with('error', 'Ви не можете видалити вже виконане завдання');
    }
}

public function markAsDone(Task $task)
{
    if ($task->canMarkAsDone()) {
        $task->update(['status' => 'done']);
        return redirect()->route('home.index')->with('success', 'Завдання відзначено як виконане');
    } else {
        return redirect()->route('home.index')->with('error', 'Неможливо відзначити завдання, доки є невиконані підзавдання');
    }
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

public function edit($id)
{
    $task = Task::findOrFail($id);
    return view('edit', compact('task'));
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
