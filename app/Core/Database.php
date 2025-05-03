<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function connect(): ?PDO
    {
        if (self::$instance === null) {
            $dsn = 'mysql:host='._ENV['DB_HOST'].';dbname='._ENV['DB_NAME'].';charset=utf8mb4';
            try {
                self::$instance = new PDO($dsn, _ENV['DB_USER'], _ENV['DB_PASS'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                error_log($e->getCode() . ' ' . $e->getMessage());
                die('Um erro inesperado ocorreu. Fale com o administrador do setor responsável');
            }
        }

        return self::$instance;
    }
}
?>