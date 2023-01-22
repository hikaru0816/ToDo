<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Folder $folder) {
        // ログインユーザーのフォルダを取得
        $folders = Auth::user()->folders()->get();
        // 選択されたフォルダに紐づくタスクを取得する
        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(Folder $folder) {
        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }

    public function create(Folder $folder, CreateTask $request) {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    public function showEditForm(Folder $folder, Task $task) {
        $this->checkRelation($folder, $task);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    public function edit(Folder $folder, Task $task, EditTask $request) {
        $this->checkRelation($folder, $task);

        // 編集内容の保存
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
        // タスク一覧画面へ
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    private function checkRelation(Folder $folder, Task $task) {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}
