<?php

namespace App\Core;

class Request
{
    private array $api = [];
    private array $body = [];
    private array $queryParams = [];

    public function __construct()
    {
        $this->api = Sanitize::xss(json_decode(file_get_contents("php://input"), true) ?? []);
        $this->body = Sanitize::xss($_POST ?? []);
        $this->queryParams = Sanitize::xss($_GET ?? []);
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function uri(): string
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        return rtrim($uri, '/') ?: '/';
    }

    public function body(array $rules): ?array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $data = [];

        if (str_contains($contentType, 'application/json')) {
            $data =  $this->api;
        }

        if (str_contains($contentType, 'application/x-www-form-urlencoded')) {
            $data = $this->body;
        }

        return Sanitize::clean($data, $rules);
    }

    public function data(string $key): mixed
    {
        return htmlspecialchars(trim($this->body[$key] ?? null), ENT_QUOTES, 'UTF-8');
    }

    public function query(string $key): mixed
    {
        return $this->queryParams[$key] ?? null;
    }

    public function allQuery(): ?array
    {
        return $this->queryParams;
    }
}
