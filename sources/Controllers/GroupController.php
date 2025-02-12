<?php

namespace App\Controllers;

use App\Models\GroupPermission;
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


    dd($group->getOwner());

    if (!$group) {
      return $this->render('errors/404');
    }

    return $this->render('groups/index', ['group' => $group]);
  }

  public function all()
  {
    var_dump('The current users\' group');
    dd($this->user->getUserGroups());
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

    $group->addOwner($this->user);

    $group->save();

    return $this->redirect('/groups/create');
  }

  public function deleteForm(int $groupId)
  {
    $group = Group::find($groupId);

    if (!$group) {
      return $this->render('errors/404', ['errors' => 'Le groupe n\'exsite pas']);
    }

    if (!$this->user->isSame($group->getOwner())) {
      return $this->render('errors/401', ['errors' => 'Tu n\'est pas autorisé pour effectuer cette action']);
    }

    return $this->render('groups/delete', ['groupId' => $group->getId()]);
  }

  public function remove(int $groupId)
  {
    $request = new GroupRequest();

    if ($request->_method !== 'delete') {
      return $this->render('errors/405', ['errors' => 'méthode non autorisée.']);
    }

    $group = Group::find($groupId);

    if (!$group) {
      return $this->render('errors/404', ['errors' => 'Le groupe n\'exsite pas !']);
    }

    if (!$this->user->isSame($group->getOwner())) {
      return $this->render('errors/401', ['errors' => 'Tu n\'est pas autorisé pour effectuer cette action']);
    }

    $group->delete();

    return $this->render('home/index', ['success' => 'le groupe a été bien supprimé']);
  }
}
