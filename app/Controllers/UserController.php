<?php
namespace App\Controllers;

use \App\Core\Request;
use \App\Core\Response;
use \App\Models\UserModel;

class UserController
{
    public static function index(Request $request, mixed $param): void
    {
        Response::json(UserModel::all());
    }

    public static function store(Request $request, mixed $param): void
    {
        $data = $request->body([
            'name' => 'string',
            'email' => 'email',
            'perfil' => 'string',
            'password' => 'string'
        ]);

        $validator = new \App\Core\Validator();

        if (!$validator->validate($data, [
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email'],
            'perfil' => ['required'],
            'password' => ['required', 'min:8']
        ])) {
            Response::json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
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

    public static function delete(Request $request, mixed $param): void
    {
        $id = (int) $param;

        if (!UserModel::findById($id)) {
            Response::json(['error' => 'Usuário não encontrado'], 404);
        }

        if (UserModel::delete((int) $id)) {
            Response::json(['message' => 'Usuário deletado com sucesso']);
        } else {
            Response::json(['error' => 'Erro ao deletar usuário'], 400);
        }
    }

    public static function update(Request $request, mixed $param): void
    {
        $id = (int) $param;

        $data = $request->body([
            'name' => 'string',
            'email' => 'email',
        ]);

        if ((!isset($data['name'])) && (!isset($data['email']))) {
            Response::json(['error' => 'Nada para atualizar'], 500);
        }

        $validator = new \App\Core\Validator();
        $rules = [];

        if (isset($data['name'])) $rules['name'] = ['min:5'];
        if (isset($data['email'])) $rules['email'] = ['email'];

        if (!$validator->validate($data, $rules)) {
            Response::json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
            exit();
        }

        if (!UserModel::findById($id)) {
            Response::json(['error' => 'Usuário não encontrado'], 500);
        }

        if (UserModel::update($data, $id)) {
            Response::json(['message' => 'Usuário atualizado com sucesso']);
        } else {
            Response::json(['error' => 'Erro ao atualizar usuário'], 401);
        }
    }
}
?>