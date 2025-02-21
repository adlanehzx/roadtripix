<?php

namespace App\Services\Validator;

class ImageValidator
{
    private $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    ];
    private $maxSize = 10 * 1024 * 1024; // 10MB

    public function validate(array $file): bool
    {
        return $this->validateType($file['type']) && $this->validateSize($file['size']);
    }

    private function validateType(string $type): bool
    {
        return in_array($type, $this->allowedTypes, true);
    }

    private function validateSize(int $size): bool
    {
        return $size <= $this->maxSize;
    }
}
