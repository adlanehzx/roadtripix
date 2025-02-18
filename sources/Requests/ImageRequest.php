<?php

namespace App\Requests;

class ImageRequest extends Request
{
    public ?int $id = null;
    public ?string $_method = null;
    public $name;
    public $description;
    public $user_id;
    public $group_id;
    public $uploaded_at;
    public $image_file;

    public function __construct()
    {
        parent::__construct();
        $this->id = $this->data['id'] ?? null;
        $this->_method = $this->data['_method'] ?? null;
        $this->name = $this->data['name'] ?? null;
        $this->description = $this->data['description'] ?? null;
        $this->group_id = $this->data['group_id'] ?? null;
        $this->image_file = $_FILES['image_file'] ?? null;
    }

    public function validate(): bool
    {
        return
            !empty($this->group_id)
            && $this->validateFile();
    }

    protected function validateFile(): bool
    {
        return isset($this->image_file) && $this->image_file['error'] === UPLOAD_ERR_OK;
    }
}
