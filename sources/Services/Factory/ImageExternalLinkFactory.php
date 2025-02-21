<?php

namespace App\Services\Factory;

use App\Models\ImageExternalLink;

use App\Models\Image;

class ImageExternalLinkFactory
{
    public static function createFromDatabase(array $data): ImageExternalLink
    {
        $imageExternalLink = new ImageExternalLink();

        $imageExternalLink->setId($data['id'] ?? null);
        $imageExternalLink->setImage(Image::find($data['image_id'])); // Assuming you have a method to get Image by ID
        $imageExternalLink->setToken($data['token'] ?? null);
        $imageExternalLink->setExpiresAt(isset($data['expires_at']) ? new \DateTime($data['expires_at']) : null);

        return $imageExternalLink;
    }
}
