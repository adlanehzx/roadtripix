<?php

namespace App\Requests;

abstract class Request
{
    protected array $data;

    public function __construct()
    {
        $this->data = $this->sanitize($this->getRequestData());
    }

    protected function getRequestData(): array
    {
        return match ($_SERVER['REQUEST_METHOD']) {
            'POST' => $_POST,
            'GET' => $_GET,
            'DELETE' => $_GET,
            default => [],
        };
    }

    protected function sanitize(array $data): array
    {
        $sanitized = [];
        foreach ($data as $key => $value) {
            $sanitized[$key] = strtolower(trim(htmlspecialchars($value)));
        }
        return $sanitized;
    }

    public function getData(): array
    {
        return $this->data;
    }

    abstract public function validate(): bool;
}
