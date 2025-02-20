<?php

namespace App\Controllers;

use App\Requests\GroupRequest;

use App\Models\Group;

class GroupController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(int $groupId)
  {
    $group = Group::find($groupId);

    if (!$group) {
      return $this->render('errors/404');
    }

    if (!$this->user->belongsTo($group)) {
      return $this->render('errors/404', ['errors' => 'Tu n\'est pas autorisé pour effectuer cette action']);
    }

    $groupImages = $group->getGroupImages();
    $groupUsers = $group->getGroupUsers();

    return $this->render('groups/index', [
      'group' => $group,
      'groupUsers' => $groupUsers,
      'groupImages' => $groupImages,
    ]);
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
      ->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));

    $group->save();
    $group->addOwner($this->user);

    return $this->redirect('/');
  }

  public function deleteForm(int $groupId)
  {
    $group = Group::find($groupId);

    if (!$group) {
      return $this->render('errors/404', ['errors' => 'Le groupe n\'exsite pas']);
    }

    if (!$this->user->owns($group)) {
      return $this->render('errors/401', ['errors' => 'Tu n\'est pas autorisé pour effectuer cette action']);
    }

    return $this->render('groups/delete', ['groupId' => $group->getId()]);
  }

  public function remove(int $groupId)
  {
      $request = new GroupRequest();
  
      if ($request->_method !== 'delete') {
          return $this->render('errors/405', ['errors' => 'Méthode non autorisée.']);
      }
  
      $group = Group::find($groupId);
  
      if (!$group) {
          return $this->render('errors/404', ['errors' => 'Le groupe n\'existe pas !']);
      }
  
      if (!$this->user->isSame($group->getOwner())) {
          return $this->render('errors/401', ['errors' => 'Tu n\'es pas autorisé pour effectuer cette action']);
      }
  
      $group->delete();
  
      return $this->redirect('/');
  }
}
