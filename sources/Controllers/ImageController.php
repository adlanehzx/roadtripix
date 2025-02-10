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

    public function index(int $groupId)
    {
        dd($groupId);
    }

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
        return $this->render('images/create', ['groupId' => $groupId]);
    }

    public function store(int $groupId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            return $this->render('errors/404');
        }

        $request = new ImageRequest();

        if (!$request->validate()) {
            return $this->render('images/create', ['errors' => ['Y a eu une erreur avec les données']]);
        }

        $image = new Image();

        $image->setImageUrl($request->image_url)
            ->setDescription($request->description)
            ->setUser($this->user)
            ->setGroup($group)
            ->setUploadedAt($request->uploaded_at);

        $image->save();

        return $this->redirect('/images');
    }
}
