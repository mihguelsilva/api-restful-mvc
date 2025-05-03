<?php
namespace App\Controllers;

use \App\Core\Request;
use \App\Core\Response;

class AdminController
{
    public static function index(Request $request): void
    {
        Response::json(['message' => 'Essa é uma área administrativa']);
    }
}
?>