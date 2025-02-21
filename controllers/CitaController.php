<?php

namespace Controllers;

use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /login');
        }

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre']
        ]);
    }
}