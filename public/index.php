<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Controllers\LoginController;
use Controllers\PacienteController;
use MVC\Router;

$router = new Router();

//Inicar sesión
$router->get('/',[LoginController::class, 'login']);
$router->post('/',[LoginController::class, 'login']);
$router->get('/logout',[LoginController::class, 'logout']);

//Recuperar contraseña
$router->get('/olvide',[LoginController::class, 'olvide']);
$router->post('/olvide',[LoginController::class, 'olvide']); 
$router->get('/recuperar',[LoginController::class, 'recuperar']);
$router->post('/recuperar',[LoginController::class, 'recuperar']);

//Crear cuenta
$router->get('/crear-usuario',[LoginController::class, 'crear']);
$router->post('/crear-usuario',[LoginController::class, 'crear']); 

//Crear paciente
$router->get('/crear-paciente',[PacienteController::class, 'registro']);
$router->post('/crear-paciente',[PacienteController::class, 'registro']);

//Actualizar paciente
$router->get('/busqueda-registro',[PacienteController::class, 'actualizar']);
$router->post('/busqueda-registro',[PacienteController::class, 'actualizar']); 

//Inicio
$router->get('/Inicio',[LoginController::class, 'inicio']);

//busqueda del paciente
$router->get('/busqueda',[PacienteController::class, 'busqueda']);
$router->post('/busqueda',[PacienteController::class, 'busqueda']);

//lista de deudores
$router->get('/deudores',[LoginController::class, 'deudores']);
$router->post('/deudores',[LoginController::class, 'deudores']);

//lista de busqueda
$router->get('/lista-busqueda',[PacienteController::class, 'lista']);
$router->post('/lista-busqueda',[PacienteController::class, 'lista']);

//Confirmar cuenta
$router->get('/confirmar-cuenta',[LoginController::class, 'confirmar']);
$router->get('/mensaje',[LoginController::class, 'mensaje']);

//API de pacientes
$router->get('/api/crear-paciente',[APIController::class, 'index']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();