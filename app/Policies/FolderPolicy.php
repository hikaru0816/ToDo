<?php

namespace App\Policies;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{
    public function view(User $user, Folder $folder) {
        return $user->id === $folder->user_id;
    }
}
