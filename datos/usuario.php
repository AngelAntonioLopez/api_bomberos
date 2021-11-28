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
        case 'mostrarporid':
            mostrarporid($conn);
            break;
        default:
            echo json_encode(array("mensaje" => "No hay una accion: " . $accion));
            break;
    }
} else {
    echo json_encode(array("mensaje" => "No se esta trayendo la accion"));
}

function insertar($con)
{
    if (
        isset($_REQUEST['nombre']) &&
        isset($_REQUEST['correo']) &&
        isset($_REQUEST['clave']) &&
        isset($_REQUEST['telefono']) &&
        isset($_REQUEST['tipo'])
    ) {
        $nombre = $_REQUEST['nombre'];
        $correo = $_REQUEST['correo'];
        $clave = $_REQUEST['clave'];
        $telefono = $_REQUEST['telefono'];
        $tipo = $_REQUEST['tipo'];

        $query = "INSERT INTO `usuario` (`nombre`, `correo`, `clave`, `telefono`, `tipo`) VALUES 
        ('" . $nombre . "', '" . $correo . "', '" . $clave . "', '" . $telefono . "', '" . $tipo . "');";
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
        isset($_REQUEST['id']) &&
        isset($_REQUEST['nombre']) &&
        isset($_REQUEST['correo']) &&
        isset($_REQUEST['clave']) &&
        isset($_REQUEST['telefono']) &&
        isset($_REQUEST['tipo'])
    ) {
        $id = $_REQUEST['id'];
        $nombre = $_REQUEST['nombre'];
        $correo = $_REQUEST['correo'];
        $clave = $_REQUEST['clave'];
        $telefono = $_REQUEST['telefono'];
        $tipo = $_REQUEST['tipo'];

        $query = "UPDATE `usuario` SET `nombre` = '" . $nombre . "', `correo` = '" . $correo . "', `clave` = '" . $clave . "', `telefono` = '" . $telefono . "', `tipo` = '" . $tipo . "' WHERE (`id_usuario` = '" . $id . "');";
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
    if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $query = "DELETE FROM `usuario` WHERE (`id_usuario` = '" . $id . "');";
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
    $query = "SELECT * FROM usuario;";
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

function mostrarporid($con)
{
    if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];

        $query = "SELECT * FROM usuario where id_usuario = '" . $id . "';";
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

function login($con){
    if (isset($_REQUEST['correo']) && isset($_REQUEST['clave'])) {
        $clave = $_REQUEST['clave'];
        $correo = $_REQUEST['correo'];
        $query = "SELECT * FROM usuario where correo = '".$correo."' and clave = '".$clave."'";
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