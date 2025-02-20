<?php

namespace App\Controllers;

use App\Models\GroupPermission;
use App\Models\Group;
use App\Models\User;
use App\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $group = Group::find(15);

        $user = User::find(13);

        $group->addWriteAccess($user);

        dd('finished');
    }

    public function appendToGroup(int $groupId, int $userId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            return $this->render('errors/404', ['errors' => 'Le groupe n\'existe pas']);
        }

        if (!$this->user->isSame($group->getOwner())) {
            return $this->render('errors/401', ['errors' => 'Tu n\'est pas autorisé pour effectuer cette action']);
        }

        $user = User::find($userId);

        if (!$user) {
            return $this->render('errors/404', ['errors' => 'L\'utilisateur n\'existe pas']);
        }

        $group->addMember($user);

        $group->save();
    }
}
