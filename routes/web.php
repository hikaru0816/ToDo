<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ログイン状態じゃないとログインできないようにする
Route::group(['middleware' => 'auth'], function() {
    // ホーム画面
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // フォルダの新規作成
    Route::get('/folders/create', [FolderController::class, 'showCreateForm'])->name('folders.create');
    Route::post('/folders/create', [FolderController::class, 'create']);

    Route::group(['middleware' => 'can:view,folder'], function() {
        // タスク一覧表示
        Route::get('/folders/{folder}/tasks', [TaskController::class, 'index'])->name('tasks.index');

        // タスクの新規作成
        Route::get('/folders/{folder}/tasks/create', [TaskController::class, 'showCreateForm'])->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', [TaskController::class, 'create']);

        // タスクの編集機能
        Route::get('folders/{folder}/tasks/{task}/edit', [TaskController::class, 'showEditForm'])->name('tasks.edit');
        Route::post('folders/{folder}/tasks/{task}/edit', [TaskController::class, 'edit']);
    });


});

Auth::routes();
