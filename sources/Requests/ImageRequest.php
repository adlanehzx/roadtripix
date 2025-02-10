<?php

namespace App\Requests;

class ImageRequest extends Request
{
    public $name;
    public $image_url;
    public $description;
    public $user_id;
    public $group_id;
    public $uploaded_at;

    public function __construct()
    {
        parent::__construct();
        $this->name = $this->data['name'];
        $this->image_url = $this->data['image_url'];
        $this->description = $this->data['description'];
        $this->user_id = $this->data['user_id'];
        $this->group_id = $this->data['group_id'];
        $this->uploaded_at = $this->data['uploaded_at'];
    }

    public function validate(): bool
    {
        return !empty($this->name) && !empty($this->image_url) && !empty($this->user_id) && !empty($this->group_id);
    }
}
