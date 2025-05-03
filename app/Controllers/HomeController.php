<?php
namespace App\Controllers;

use \App\Core\Request;
use \App\Core\Response;
use \App\Models\UserModel;

class HomeController
{
    public static function index(Request $request): void
    {
        Response::json(UserModel::all());
    }

    public static function store(Request $request): void
    {
        $data = $request->body();

        if ((!isset($data['name'])) || (!isset($data['email'])) || (!isset($data['password']))) {
            Response::json(['error' => 'Processo de cadastro incompleto'], 500);
        }

        if (UserModel::findByEmail($data['email'])) {
            Response::json(['error' => 'Usuário já foi registrado'], 404);
        }

        if (UserModel::create($data)) {
            Response::json(['message' => 'Usuário criado com sucesso']);
        } else {
            Response::json(['error' => 'Não foi possível criar o usuário'], 500);
        }
    }
}
?>