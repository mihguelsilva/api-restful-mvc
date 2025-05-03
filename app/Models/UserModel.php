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

    public static function create(array $data): bool
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        return $stmt->execute([
            ":name" => $data['name'],
            ":email" => $data['email'],
            ":password" => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }
}

?>