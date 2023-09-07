<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTaskOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    $taskId = $request->route('task');
    $task = Task::find($taskId);

    if (!$task) {
        return response()->json(['message' => 'Task not found'], 404);
    }

    if ($task->user_id !== Auth::id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    return $next($request);
	}
}
