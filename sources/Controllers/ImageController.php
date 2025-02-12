<?php

namespace App\Controllers;

use App\Requests\ImageRequest;
use App\Models\Image;
use App\Models\User;
use App\Models\Group;

class ImageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(int $groupId) {}

    public function all(int $groupId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            return $this->render('errors/404');
        }

        dd($group->getGroupImages());
    }

    public function create(int $groupId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            return $this->render('errors/404', ['errors' => 'Le groupe n\'exsite pas']);
        }

        if (!$this->user->belongsTo($group)) {
            return $this->render('errors/401', ['errors' => 'Tu n\'appartiens pas au groupe']);
        }

        return $this->render('images/create', ['groupId' => $groupId]);
    }

    public function store(int $groupId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            return $this->render('errors/404', ['errors' => 'Le groupe n\'exsite pas']);
        }

        if (!$this->user->belongsTo($group)) {
            return $this->render('errors/401', ['errors' => 'Tu n\'appartiens pas au groupe']);
        }

        $request = new ImageRequest();

        if (!$request->validate()) {
            return $this->render('images/create', ['errors' => 'Y a eu une erreur avec les données']);
        }

        $image = new Image();

        $image
            ->setImageUrl($request->image_url)
            ->setDescription($request->description)
            ->setUser($this->user)
            ->setGroup($group)
            ->setUploadedAt(date('Y-m-d H:i:s'));
        $image->save();

        dd('image saved');

        return $this->redirect('/images');
    }


    public function deleteForm(int $groupId, int $imageId)
    {
        $group = Group::find($groupId);
        $image = Image::find($imageId);

        if (!$group || !$image) {
            return $this->render('errors/404');
        }

        return $this->render(
            'images/delete',
            [
                'imageId' => $image->getId(),
                'groupId' => $group->getId(),
            ]
        );
    }

    public function remove(int $groupId, int $imageId)
    {
        $request = new ImageRequest();

        if (!$request->_method === 'delete') {
            return $this->render('errors/405', ['errors' => 'méthode non autorisée']);
        }

        $group = Group::find($groupId);
        $image = Image::find($imageId);

        if (!$group || !$image) {
            return $this->render('errors/404', ['errors' => 'Le groupe ou la photo n\'exsite pas']);
        }

        if ($this->user->belongsTo($group)) {
            return $this->render('errors/401', ['errors' => 'Tu n\'appartiens pas au groupe']);
        }

        $imageOwner = $image->getUser();
        $groupOwner = $image->getGroup()->getOwner();

        if (
            !$this->user->isSame($imageOwner)
            && !$this->user->isSame($groupOwner)
        ) {
            return $this->render('errors/401', ['errors' => 'Vous n\'avez pas la permission de supprimer cette image']);
        }

        $image->delete();

        return $this->redirect('/');
    }
}
