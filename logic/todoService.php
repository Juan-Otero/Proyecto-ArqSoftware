<?php

require('../data/todoDataAccess.php');

function crearTarea($conexion){
    $input = json_decode(file_get_contents('php://input'), true);

    $descripcion = $input['descripcion'] ?? null;
    $fecha       = $input['fecha']       ?? null;
    $estado      = $input['estado']      ?? null;
    $prioridad   = isset($input['prioridad']) ? (int)$input['prioridad'] : null;

    // Validaciones básicas
    if (!$descripcion || !$fecha || $estado != 0 || $prioridad === null) {
        http_response_code(400);
        return json_encode(['error' => 'Faltan datos obligatorios']);
    }

    // Llamada al DAO pasando la conexión
    return crearTareaDAO($conexion, $descripcion, $fecha, $estado, $prioridad);
}

function listarTareas($conexion){

    return listarTareasDAO($conexion);

}

function actualizarTarea($conexion, $id){

    if ($id <= 0) {
        return json_encode([
            'esError' => true,
            'message' => "ID inválido: $id"
        ]);
    }

    if ($id == null) {
        return json_encode([
            'esError' => true,
            'message' => "ID inválido: $id"
        ]);
    }

    return actualizarTareaDAO($conexion, $id);
}

function eliminarTarea($conexion, $id){

    if ($id !== null) {
        return eliminarTareaDAO($conexion, $id);
    }else {
        return json_encode([
            'esError' => true,
            'message' => 'No se pudo eliminar el registro'
        ]);
    }
}

function obtenerById($conexion, $id){
    if ($id <= 0) {
        return json_encode([
            'esError' => true,
            'message' => "ID inválido: $id"
        ]);
    }

    if ($id == null) {
        return json_encode([
            'esError' => true,
            'message' => "ID inválido: $id"
        ]);
    }
    
    return obtenerByIdDAO($conexion, $id);
}