<?php

$servidor = "mysql:dbname=empresa;host=127.0.0.1";
$usuario = "root";
$password = "";

try {
    //code...
    $pdo = new PDO($servidor, $usuario, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    echo "Conectado exitosamente...";
} catch (PDOException $e) {
    echo "Conexion mala :( " . $e->getMessage();
    //throw $th;
}
