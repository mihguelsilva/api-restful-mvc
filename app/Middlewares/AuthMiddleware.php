<?php
namespace App\Middlewares;

use \App\Core\Request;
use \App\Core\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    public static function handle(Request $request): void
    {
        $headers = getallheaders();
        $authorization = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$authorization || !str_starts_with($authorization, 'Bearer ')) {
            Response::json(['error' => 'Token não fornecido ou inválido'], 401);
        }

        $token = trim(str_replace('Bearer ', '', $authorization));

        try {
            $decoded = JWT::decode($token, new Key(_ENV['JWT_SECRET'], 'HS256'));
        } catch (\Exception $e) {
            error_log($e->getCode() . ' ' . $e->getMessage());
            Response::json(['error' => 'Token inválido ou expirado'], 401);
        }

    }
}
?>