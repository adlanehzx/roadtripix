<?php

namespace App\Controllers;

use App\Models\GroupPermission;
use App\Models\UserGroupPermission;
use App\Requests\GroupRequest;

use App\Models\Group;

class GroupController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(int $id)
  {
    $group = Group::find($id);

    if (!$group) {
      return $this->render('errors/404');
    }

    return $this->render('groups/index', ['group' => $group]);
  }

  public function create()
  {
    return $this->render('groups/create');
  }

  public function store()
  {
    $request = new GroupRequest();

    if (!$request->validate()) {
      return $this->render('groups/create', ['errors' => ['Y a eu une erreur avec les données']]);
    }

    $group = (new Group())
      ->setName($request->name)
      ->setCreatedAt(date('Y-m-d H:i:s'));

    $group->save();

    $permission = (new UserGroupPermission())
      ->setGroupId($group->getId())
      ->setUserId($this->user->getId())
      ->setPermissionId(GroupPermission::findByName(GroupPermission::GROUP_OWNER)->getId());

    $permission->save();

    return $this->redirect('/groups');
  }
}