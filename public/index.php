<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use MVC\Router;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;

$router = new Router();

//Iniciar sesion
$router->get('/', [new LoginController(), 'login']);
$router->post('/', [new LoginController(), 'login']);
$router->get('/logout', [new LoginController(), 'logout']);

//Recuperar password
$router->get('/olvide', [new LoginController(), 'olvide']);
$router->post('/olvide', [new LoginController(), 'olvide']);
$router->get('/recuperar', [new LoginController(), 'recuperar']);
$router->post('/recuperar', [new LoginController(), 'recuperar']);

//Crear Cuenta
$router->get('/crear-cuenta', [new LoginController(), 'crear']);
$router->post('/crear-cuenta', [new LoginController(), 'crear']);

//Confirmar cuenta
$router->get('/confirmar-cuenta', [new LoginController(), 'confirmar']);
$router->get('/mensaje', [new LoginController(), 'mensaje']);

//Area privada
$router->get('/cita', [new CitaController(), 'index']);
$router->get('/admin', [new AdminController(), 'index']);

//API de citas
$router->get('/api/servicios', [new APIController(), 'index']);
$router->post('/api/citas', [new APIController(), 'guardar']);
$router->post('/api/eliminar', [new APIController(), 'eliminar']);

//Crud de servicios
$router->get('/servicios', [new ServicioController(), 'index']);
$router->get('/servicios/crear', [new ServicioController(), 'crear']);
$router->post('/servicios/crear', [new ServicioController(), 'crear']);
$router->get('/servicios/actualizar', [new ServicioController(), 'actualizar']);
$router->post('/servicios/actualizar', [new ServicioController(), 'actualizar']);
$router->post('/servicios/eliminar', [new ServicioController(), 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();