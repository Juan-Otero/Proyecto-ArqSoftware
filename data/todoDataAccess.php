<?php

function crearTareaDAO($conexion, $descripcion, $fecha, $estado, $prioridad){

    $sql = "INSERT INTO tareas (descripcion, fechaLimite, estado, prioridad) VALUES ('$descripcion', '$fecha', $estado, $prioridad)";

    $conexion->exec($sql);

    $ultimoId = $conexion->lastInsertId();

    $input['id'] = $ultimoId;

    return json_encode($input);
}

function listarTareasDAO($conexion){

    $sql = "SELECT ID, descripcion, estado, prioridad FROM tareas";

    $stmtSelect = $conexion->prepare($sql);
    $stmtSelect->execute();

    // Obtener los resultados y mostrarlos
    $usuarios = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    return json_encode($usuarios);
}

function actualizarTareaDAO($conexion, $id){

    $sql = "UPDATE tareas SET estado = 1 where ID = $id";
    $conexion->exec($sql);

    return obtenerById($conexion, $id);
}

function eliminarTareaDAO($conexion, $id){

        $sql = "DELETE FROM tareas WHERE ID = $id";
        $conexion->exec($sql);
        return json_encode([
            'eliminado' => true,
            'mensaje' => 'Registro eliminado correctamente'
        ]);
}

function obtenerByIdDAO($conexion, $id){

    $sql = "SELECT ID, descripcion, estado, prioridad FROM tareas WHERE id = $id";

    $stmtSelect = $conexion->prepare($sql);
    $stmtSelect->execute();

    // Obtener los resultados y mostrarlos
    $usuarios = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    return json_encode($usuarios);
}
