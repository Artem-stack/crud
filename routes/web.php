<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubtaskController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::resource('home', HomeController::class);

    // Роути для підзадач
    Route::prefix('home/{task}')->group(function () {
        Route::post('subtasks', [HomeController::class, 'storeSubtask'])->name('home.subtasks.store');
        Route::put('subtasks/{subtask}', [HomeController::class, 'updateSubtask'])->name('home.subtasks.update');
    });

    // Роут для позначення завдання як виконане
    Route::put('home/{task}/markAsDone', [HomeController::class, 'markAsDone'])->name('home.markAsDone');

    // Роути для підзадачі
    Route::resource('subtasks', SubtaskController::class);
    Route::prefix('tasks/{task}')->group(function () {
        Route::get('subtasks', [SubtaskController::class, 'index'])->name('tasks.subtasks.index');
        Route::post('subtasks', [SubtaskController::class, 'store'])->name('tasks.subtasks.store');
        Route::get('subtasks/create', [SubtaskController::class, 'create'])->name('subtasks.create');

     Route::put('subtasks/{subtask}/markAsDone', [SubtaskController::class, 'markAsDone'])->name('subtasks.markAsDone');
    });
});

// Залишити доступ до деяких сторінок для всіх користувачів
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Роути для авторизації
Auth::routes();







