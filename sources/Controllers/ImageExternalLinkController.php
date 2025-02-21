<?php

namespace App\Controllers;

use App\Requests\GroupRequest;

use App\Models\Image;
use App\Models\ImageExternalLink;

class ImageExternalLinkController extends Controller
{
    public function __construct()
    {
        // we skipe auth for external links.
    }

    public function showImage(string $token)
    {
        $imageExternalLink = ImageExternalLink::getImageExternalLinkByToken($token);

        if ($imageExternalLink->isExpired() || !$imageExternalLink->getImage()) {
            return $this->render('errors/404', ['errors' => "Le lien est expiré ou la photo n'exsite plus."]);
        }

        $image = $imageExternalLink->getImage();

        return $this->render('externalImage/index', ['image' => $image]);
    }

    public function createLink(int $imageId)
    {
        $image = Image::find($imageId);

        if (!$image) {
            return;
        }

        $token = bin2hex(random_bytes(16));
        $expiresAt = (new \DateTime())->modify('+1 day');

        $imageExternalLink = new ImageExternalLink();
        $imageExternalLink->setImage($image);
        $imageExternalLink->setToken($token);
        $imageExternalLink->setExpiresAt($expiresAt);

        $imageExternalLink->save();

        $link = $this->generateLink($token);

        header('Content-Type: application/json');
        echo json_encode(['link' => $link]);
        return;
    }

    private function generateLink(string $token): string
    {
        return sprintf('%s/external-images/show/%s', $_SERVER['HTTP_HOST'], $token);
    }
}
