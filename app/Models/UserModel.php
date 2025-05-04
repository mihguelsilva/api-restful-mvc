<?php
namespace App\Models;

use \App\Core\Database;
use PDO;

class UserModel
{
    public static function all(): ?array
    {
        $pdo = Database::connect();
        $stmt = $pdo->query('SELECT * FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE ID = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public static function create(array $data): bool
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('INSERT INTO users (name, email, perfil, password) VALUES (:name, :email, :perfil, :password)');
        return $stmt->execute([
            ":name" => $data['name'],
            ":email" => $data['email'],
            ":perfil" => $data['perfil'],
            ":password" => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    public static function delete (int $id): bool
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM users WHERE ID = :id");
        return $stmt->execute([":id" => $id]);
    }

    public static function update(array $data, int $id): bool
    {
        $pdo = Database::connect();

        $fields = [];
        $params = [":id" => $id];

        if (isset($data['name'])) {
            $fields[] = 'name = :name';
            $params[":name"] = $data['name'];
        }

        if (isset($data['email'])) {
            $fields[] = 'email = :email';
            $params[":email"] = $data['email'];
        }

        $stmt = $pdo->prepare('UPDATE users SET '.implode(',', $fields).' WHERE ID = :id');
        return $stmt->execute($params);
    }
}

?>