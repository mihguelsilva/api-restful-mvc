<?php
namespace App\Core;

class Response
{
    public static function json(array $message, int $status = 200): void
    {
        http_response_code($status);
        header("Content-type: application/json");
        echo json_encode($message);
        exit();
    }
}
?>