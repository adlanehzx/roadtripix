<?php

namespace App\Requests;

class ImageRequest extends Request
{
    public ?int $id = null;
    public ?string $_method = null;
    public $name;
    public $image_url;
    public $description;
    public $user_id;
    public $group_id;
    public $uploaded_at;

    public function __construct()
    {
        parent::__construct();
        $this->id = $this->data['id'] ?? null;
        $this->_method = $this->data['_method'] ?? null;
        $this->name = $this->data['name'] ?? null;
        $this->image_url = $this->data['image_url'] ?? null;
        $this->description = $this->data['description'] ?? null;
        $this->group_id = $this->data['group_id'] ?? null;
    }

    public function validate(): bool
    {
        return
            !empty($this->name)
            && !empty($this->image_url)
            && !empty($this->group_id);
    }
}
