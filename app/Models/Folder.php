<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model {
    // リレーション
    public function tasks() {
        return $this->hasMany('App\Models\Task');
    }
}
