<?php

include '../conexion/conex.php';

$accion = "";
if (isset($_REQUEST['accion'])) {
    $accion = $_REQUEST['accion'];

    switch ($accion) {
        case 'insertar':
            insertar($conn);
            break;
        case 'actualizar':
            actualizar($conn);
            break;
        case 'eliminar':
            eliminar($conn);
            break;
        case 'listar':
            listar($conn);
            break;
        case 'mostrar':
            mostrar($conn);
            break;
        default:
            echo json_encode(array("mensaje" => "No hay una accion: " . $accion));
            break;
    }
} else {
    echo json_encode(array("mensaje" => "No se esta trayendo la accion"));
}

function insertar($con)
{//id_contacto, entidad, direccion, telefono, correo
    if (
        isset($_REQUEST['entidad']) &&
        isset($_REQUEST['direccion']) &&
        isset($_REQUEST['telefono']) &&
        isset($_REQUEST['correo']) 
    ) {
        $entidad = $_REQUEST['entidad'];
        $direccion = $_REQUEST['direccion'];
        $telefono = $_REQUEST['telefono'];
        $correo = $_REQUEST['correo'];

        $query = "INSERT INTO `contactos` (`entidad`, `direccion`, `telefono`, `correo`) VALUES 
        ('".$entidad."', '".$direccion."', '".$telefono."', '".$correo."');
        ";
        if (mysqli_query($con, $query) or die("error al insertar Usuario")) {
            echo json_encode(array("mensaje" => "insertado"));
        } else {
            echo json_encode(array("mensaje" => "error"));
        }
        mysqli_close($con);
    } else {
        echo json_encode(array("mensaje" => "error, no estan todos los campos seteados"));
    }
}

function actualizar($con)
{
    if (
        isset($_REQUEST['id_contacto']) &&
        isset($_REQUEST['entidad']) &&
        isset($_REQUEST['direccion']) &&
        isset($_REQUEST['telefono']) &&
        isset($_REQUEST['correo']) 
    ) {
        $id_contacto = $_REQUEST['id_contacto'];
        $entidad = $_REQUEST['entidad'];
        $direccion = $_REQUEST['direccion'];
        $telefono = $_REQUEST['telefono'];
        $correo = $_REQUEST['correo'];

        $query = "UPDATE `contactos` SET 
        `entidad` = '".$entidad."', 
        `direccion` = '".$direccion."', 
        `telefono` = '".$telefono."', 
        `correo` = '".$correo."' 
        WHERE (`id_contacto` = '".$id_contacto."');";

        if (mysqli_query($con, $query) or die("error al actualizar Usuario")) {
            echo json_encode(array("mensaje" => "actualizado"));
        } else {
            echo json_encode(array("mensaje" => "error"));
        }
        mysqli_close($con);
    } else {
        echo json_encode(array("mensaje" => "error, no estan todos los campos seteados"));
    }
}

function eliminar($con)
{
    if (isset($_REQUEST['id_contacto'])) {
        $id_contacto = $_REQUEST['id_contacto'];
        $query = "DELETE FROM `contactos` WHERE (`id_contacto` = '".$id_contacto."')";
        if (mysqli_query($con, $query) or die("error al eliminar Usuario")) {
            echo json_encode(array("mensaje" => "eliminardo"));
        } else {
            echo json_encode(array("mensaje" => "error"));
        }
        mysqli_close($con);
    } else {
        echo json_encode(array("mensaje" => "error, no estan todos los campos seteados"));
    }
}

function listar($con)
{
    $query = "SELECT * FROM contactos;";
    $resultado = mysqli_query($con, $query) or die("Select Query Failed.");
    $contador = mysqli_num_rows($resultado);
    if ($contador > 0) {
        $row = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode(array("mensaje" => "No hay nada"));
    }
    mysqli_close($con);
}

function mostrar($con)
{
    if (isset($_REQUEST['id_contacto'])) {
        $id_contacto = $_REQUEST['id_contacto'];
        $query = "SELECT * FROM contactos where id_contacto = '".$id_contacto."';";
        $resultado = mysqli_query($con, $query) or die("error al traer Usuario");
        $contador = mysqli_num_rows($resultado);
        if ($contador > 0) {
            $rows = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            $row = reset($rows);
            echo json_encode($row);
        } else {
            echo json_encode(array("mensaje" => "error"));
        }
        mysqli_close($con);
    } else {
        echo json_encode(array("mensaje" => "error, no estan todos los campos seteados"));
    }
}
