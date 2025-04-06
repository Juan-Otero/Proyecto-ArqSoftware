<?php
$host = "localhost";
$usuario = "root";
$password = "root";
$basededatos = "todoapp";

$conexion = new PDO("mysql:host=$host;dbname=$basededatos", $usuario, $password);
$conexion-> setAttribute(PDO :: ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);