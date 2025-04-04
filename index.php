<?php

    $host = "localhost";
    $usuario = "root";
    $password ="Paez2009+";
    $basededatos="pruebaTecnica";


$conexion = new PDO("mysql:host=$host;dbname=$basededatos", $usuario, $password);
$conexion-> setAttribute(PDO :: ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//echo "Conexión establecida";


header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$verbo = $_SERVER['REQUEST_METHOD'];

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO']: '/';
$buscarId = explode('/', $path);
$id = ($path !== '/') ? end($buscarId) : null;

switch ($verbo) 
{
    case 'GET':

        if ($id !== null) {
            obtenerById($conexion, $id);
        }
        else {
            listarTareas($conexion);
        }
        break;     

    case 'PUT':
        actualizarTarea($conexion, $id);
        break;
    case 'DELETE':
        eliminarTarea($conexion, $id);
        break;  
    case 'POST':
        crearTarea($conexion);
        break;
    default:
    echo json_encode([
        'esError' => true,
        'message' => 'Metodo no soportado'
    ]);
}


function crearTarea($conexion) { 

    $input = json_decode(file_get_contents('php://input'), true);

    $descripcion = $input['descripcion'];
    $fecha =  $input['fecha'];
    $estado =  $input['estado'];
    $prioridad =  $input['prioridad'];

    $sql = "INSERT INTO tareas (descripcion, fechaLimite, estado, prioridad) VALUES ('$descripcion', '$fecha', $estado, $prioridad)";

    $conexion -> exec($sql);
    
    $ultimoId = $conexion->lastInsertId();

    $input['id'] = $ultimoId;
  
    echo json_encode($input);
}

function listarTareas($conexion) {

    $sql = "SELECT ID, descripcion, estado, prioridad FROM tareas";

    $stmtSelect = $conexion->prepare($sql);
    $stmtSelect->execute();

     // Obtener los resultados y mostrarlos
    $usuarios = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($usuarios);
}

function actualizarTarea($conexion, $id) {

    $sql = "UPDATE tareas SET estado = 1 where ID = $id";
    $conexion -> exec($sql);

    obtenerById($conexion, $id);

}

function eliminarTarea($conexion, $id) {

    if ($id !== null) {

        $sql = "DELETE FROM Tareas WHERE ID = $id";

        $conexion -> exec($sql);
        
        echo json_encode([
            'eliminado' => true,
            'mensaje' => 'Registro eliminado correctamente'
        ]);
    }
}

function obtenerById($conexion, $id) {

    $sql = "SELECT ID, descripcion, estado, prioridad FROM tareas WHERE id = $id";

    $stmtSelect = $conexion->prepare($sql);
    $stmtSelect->execute();

     // Obtener los resultados y mostrarlos
    $usuarios = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($usuarios);
}


?>