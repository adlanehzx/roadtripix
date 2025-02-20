<?php

namespace App\Services;

use App\Models\Image;

class FilesService
{
    public function uploadImage(array $file, Image $image): bool
    {
        $destination = $this->getImageDirectoryAbsolutePath($image);

        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uploadFile = $destination . '/' . $image->getId() . '.' . $extension;
        return move_uploaded_file($file['tmp_name'], $uploadFile);
    }

    public function removeImage(Image $image): bool
    {
        $imagePath = $image->getImageUrl();

        if (file_exists($imagePath)) {
            return unlink($imagePath);
        }
        return false;
    }

    public function getImageFileAbsolutePath(?Image $image): ?string
    {
        if (empty($image)) {
            return null;
        }
        return $_ENV['PHP_USER_HOME_DIRECTORY'] . "/user_uploads/" . $image->getGroup()->getId() . '/' . $image->getId();
    }

    public function getImageDirectoryAbsolutePath(?Image $image): ?string
    {
        if (empty($image)) {
            return null;
        }
        return $_ENV['PHP_USER_HOME_DIRECTORY'] . "/user_uploads/" . $image->getGroup()->getId();
    }
}
