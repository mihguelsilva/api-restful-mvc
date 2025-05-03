<?php
namespace App\Core;

class Request
{
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function uri(): string
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        return rtrim($uri, '/') ?: '/';
    }

    public function body(): ?array
    {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }
}
?>