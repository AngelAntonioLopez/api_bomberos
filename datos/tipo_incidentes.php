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
        isset($_REQUEST['tipo_incidente'])
    ) {
        $tipo_incidente = $_REQUEST['tipo_incidente'];

        $query = "INSERT INTO `tipo_incidentes` (`tipo_incidente`) VALUES ('".$tipo_incidente."');";
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
        isset($_REQUEST['tipo_incidente']) &&
        isset($_REQUEST['id_tipo'])
    ) {
        $tipo_incidente = $_REQUEST['tipo_incidente'];
        $id_tipo = $_REQUEST['id_tipo'];

        $query = "UPDATE `bd_bomberos`.`tipo_incidentes` SET `tipo_incidente` = '".$tipo_incidente."' WHERE (`id_tipo` = '".$id_tipo."');";
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
    if (isset($_REQUEST['id_tipo'])) {
        $id_tipo = $_REQUEST['id_tipo'];
        $query = "DELETE FROM `tipo_incidentes` WHERE (`id_tipo` = '".$id_tipo."');";
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
    $query = "SELECT * FROM `tipo_incidentes`;";
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
    if (isset($_REQUEST['id_tipo'])) {
        $id_tipo = $_REQUEST['id_tipo'];

        $query = "SELECT * FROM tipo_incidentes where id_tipo = '".$id_tipo."'";
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
