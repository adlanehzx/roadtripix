<?php

namespace App\Controllers;

use App\Requests\ImageRequest;
use App\Models\Image;
use App\Models\User;
use App\Models\Group;
use App\Services\FilesService;

class ImageController extends Controller
{
    private ?FilesService $filesService = null;

    public function __construct()
    {
        parent::__construct();
        $this->filesService = new FilesService();
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
            ->setDescription($request->image_file['name'])
            ->setUser($this->user)
            ->setGroup($group)
            ->setUploadedAt(date('Y-m-d H:i:s'));
        $image->save();

        if (
            !$this->filesService->uploadImage(
                file: $request->image_file,
                image: $image
            )
        ) {
            return $this->render('images/create', ['errors' => 'Erreur lors du déplacement de l\'image téléchargée']);
        }

        $image->save();

        return $this->redirect("/group/{$groupId}");
    }

    public function deleteForm(int $groupId, int $imageId)
    {
        $group = Group::find($groupId);
        $image = Image::find($imageId);

        if (
            !$group
            || !$image
            || !$image?->belongsTo($group)
        ) {
            return $this->render('errors/404', ['errors' => 'Le groupe ou la photo n\'exsite pas']);
        }

        return $this->render(
            'images/delete',
            [
                'image' => $image,
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

        if (
            !$this->filesService->removeImage(
                image: $image
            )
        ) {
            return $this->render('/images', ['errors' => 'Une erreur est survenue lors de la suppression de l\'image.']);
        }

        $image->delete();

        return $this->redirect("/group/{$groupId}");
    }
}
