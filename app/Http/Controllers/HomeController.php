<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        // ログインユーザー情報を取得
        $user = Auth::user();
        // ログインユーザーのフォルダを1つ取得
        $folder = $user->folders()->first();
        // フォルダ未作成の場合、ホームページへ
        if (is_null($folder)) {
            return view('home');
        }
        // フォルダがあれば、そのフォルダのタスク一覧へ
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
