<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use \App\Core\Request;
use \App\Core\Response;
use \App\Models\UserModel;

class AuthController
{
    public static function login(Request $request): void
    {
        $data = $request->body([
            'email' => 'email',
            'password' => 'string'
        ]);

        if ((!isset($data['email'])) || (!isset($data['password']))) {
            Response::json(['error' => 'Dados incompletos'], 403);
        }

        $user = UserModel::findByEmail($data['email']);

        if ($user && password_verify($data['password'], $user['password'])) {

            $payload = [
                'suid' => $user['ID'],
                'email' => $user['email'],
                'perfil' => $user['perfil'],
                'iat' => time(),
                'exp' => time() + 3600
            ];

            $jwt = JWT::encode($payload, _ENV['JWT_SECRET'], 'HS256');

            Response::json([
                'message' => 'Login realizado com sucesso',
                'token' => 'Bearer ' . $jwt
            ]);
        } else {
            Response::json(['error' => 'Credenciais inválidas'], 403);
        }
    }
}
