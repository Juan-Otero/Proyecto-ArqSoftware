<?php
require('../data/conexion.php');
require('../logic/todoService.php');

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$verbo = $_SERVER['REQUEST_METHOD'];

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$buscarId = explode('/', $path);
$id = ($path !== '/') ? end($buscarId) : null;

switch ($verbo) {
    case 'GET':

        if ($id !== null) {
            echo obtenerById($conexion, $id);
        } else {
            echo listarTareas($conexion);
        }
        break;

    case 'PUT':
        echo actualizarTarea($conexion, $id);
        break;
    case 'DELETE':
        echo eliminarTarea($conexion, $id);
        break;
    case 'POST':
        echo crearTarea($conexion);
        break;
    default:
        echo json_encode([
            'esError' => true,
            'message' => 'Metodo no soportado'
        ]);
}
