<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtApellidoP = (isset($_POST['txtApellidoP'])) ? $_POST['txtApellidoP'] : "";
$txtApellidoM = (isset($_POST['txtApellidoM'])) ? $_POST['txtApellidoM'] : "";
$txtCorreo = (isset($_POST['txtCorreo'])) ? $_POST['txtCorreo'] : "";
$txtFoto = (isset($_FILES['txtFoto']["name"])) ? $_FILES['txtFoto']["name"] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

$error = array();

include("../conexion/conexion.php");
$accionAgregar = "";
$accionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

switch ($accion) {
    case "btnAgregar":
        if ($txtNombre == "") {
            $error['Nombre'] = "Escribe el nombre";
        }
        if ($txtApellidoP == "") {
            $error['ApellidoP'] = "Escribe el apellidoP";
        }
        if ($txtApellidoM == "") {
            $error['ApellidoM'] = "Escribe el apellidoM";
        }
        if ($txtCorreo == "") {
            $error['Correo'] = "Escribe el correo";
        }
        if (count($error) > 0) {
            $mostrarModal = true;
            break;
        }


        $sentencia = $pdo->prepare("INSERT INTO empleados(Nombre,ApellidoP,ApellidoM,Correo,Foto) 
            Values(:Nombre,:ApellidoP,:ApellidoM,:Correo,:Foto)");
        $sentencia->bindParam(':Nombre', $txtNombre);
        $sentencia->bindParam(':ApellidoP', $txtApellidoP);
        $sentencia->bindParam(':ApellidoM', $txtApellidoM);
        $sentencia->bindParam(':Correo', $txtCorreo);

        $Fecha = new DateTime();
        $nombreArchivo = ($txtFoto != "") ? $Fecha->getTimestamp() . "_" . $_FILES["txtFoto"]["name"] : "imagen.jpg";

        $tmpFoto = $_FILES["txtFoto"]["tmp_name"];

        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "../Imagenes/" . $nombreArchivo);
        }

        $sentencia->bindParam(':Foto', $nombreArchivo);
        $sentencia->execute();

        break;
    case "btnModificar":

        $sentencia = $pdo->prepare(" UPDATE empleados SET
            Nombre=:Nombre,
            ApellidoP=:ApellidoP,
            ApellidoM=:ApellidoM,
            Correo=:Correo WHERE ID=:ID");

        $sentencia->bindParam(':Nombre', $txtNombre);
        $sentencia->bindParam(':ApellidoP', $txtApellidoP);
        $sentencia->bindParam(':ApellidoM', $txtApellidoM);
        $sentencia->bindParam(':Correo', $txtCorreo);

        $sentencia->bindParam(':ID', $txtID);
        $sentencia->execute();

        $Fecha = new DateTime();
        $nombreArchivo = ($txtFoto != "") ? $Fecha->getTimestamp() . "_" . $_FILES["txtFoto"]["name"] : "imagen.jpg";

        $tmpFoto = $_FILES["txtFoto"]["tmp_name"];

        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "../Imagenes/" . $nombreArchivo);

            $sentencia = $pdo->prepare("SELECT Foto FROM empleados WHERE ID=:ID");
            $sentencia->bindParam(':ID', $txtID);
            $sentencia->execute();
            $empleado = $sentencia->fetch(PDO::FETCH_LAZY);
            print_r($empleado);

            if (isset($empleado["Foto"])) {
                if (file_exists("../Imagenes/" . $empleado["Foto"])) {
                    if ($empleado['Foto'] != "imagen.jpg") {
                        unlink("../Imagenes/" . $empleado["Foto"]);
                    }
                }
            }

            $sentencia = $pdo->prepare(" UPDATE empleados SET  Foto=:Foto WHERE ID=:ID");
            $sentencia->bindParam(':Foto', $nombreArchivo);
            $sentencia->bindParam(':ID', $txtID);
            $sentencia->execute();
        }
        header('Location: index.php');
        break;
    case "btnEliminar":
        $sentencia = $pdo->prepare("SELECT Foto FROM empleados WHERE ID=:ID");
        $sentencia->bindParam(':ID', $txtID);
        $sentencia->execute();
        $empleado = $sentencia->fetch(PDO::FETCH_LAZY);
        print_r($empleado);

        if (isset($empleado["Foto"]) && ($empleado['Foto'] != "imagen.jpg")) {
            if (file_exists("../Imagenes/" . $empleado["Foto"])) {
                unlink("../Imagenes/" . $empleado["Foto"]);
            }
        }

        $sentencia = $pdo->prepare(" DELETE FROM empleados WHERE ID=:ID");
        $sentencia->bindParam(':ID', $txtID);
        $sentencia->execute();
        header('Location: index.php');


        break;
    case "btnCancelar":
        header('Location: index.php');
        break;
    case "Seleccionar":
        $accionAgregar = "disabled";
        $accionModificar = $accionEliminar = $accionCancelar = "";
        $mostrarModal = true;

        $sentencia = $pdo->prepare("SELECT * FROM empleados WHERE ID=:ID");
        $sentencia->bindParam(':ID', $txtID);
        $sentencia->execute();
        $empleado = $sentencia->fetch(PDO::FETCH_LAZY);

        $txtNombre = $empleado['Nombre'];
        $txtApellidoP = $empleado['ApellidoP'];
        $txtApellidoM = $empleado['ApellidoM'];
        $txtCorreo = $empleado['Correo'];
        $txtFoto = $empleado['Foto'];

        break;
}
$sentencia = $pdo->prepare("SELECT * FROM `empleados` WHERE 1");
$sentencia->execute();
$listaEmpleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        // print_r($listaEmpleados);
