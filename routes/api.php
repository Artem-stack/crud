<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/tasks/index', 'TaskController@index');

Route::resource('tasks', 'TaskController');
Route::put('tasks/{task}/markAsDone', 'TaskController@markAsDone');

Route::post('tasks/{task}/subtasks', 'TaskController@storeSubtask')->middleware('auth');
Route::put('tasks/{task}/subtasks/{subtask}', 'TaskController@updateSubtask')->middleware('auth');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
