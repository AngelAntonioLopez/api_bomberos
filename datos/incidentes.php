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
{
    if (
        isset($_REQUEST['tipo']) &&
        isset($_REQUEST['descripcion']) &&
        isset($_REQUEST['direccion']) &&
        isset($_REQUEST['gravedad']) &&
        isset($_REQUEST['fecha_hora']) &&
        isset($_REQUEST['personas_lesionadas']) &&
        isset($_REQUEST['costo_danios'])
    ) {
        $tipo = $_REQUEST['tipo'];
        $descripcion = $_REQUEST['descripcion'];
        $direccion = $_REQUEST['direccion'];
        $gravedad = $_REQUEST['gravedad'];
        $fecha_hora = $_REQUEST['fecha_hora'];
        $personas_lesionadas = $_REQUEST['personas_lesionadas'];
        $costo_danios = $_REQUEST['costo_danios'];

        $query = "INSERT INTO `incidentes` (`tipo`, `descripcion`, `direccion`, `gravedad`, `fecha_hora`, `personas_lesionadas`, `costo_danios`) VALUES 
        ('".$tipo."', '".$descripcion."', '".$direccion."', '".$gravedad."', '".$fecha_hora."', '".$personas_lesionadas."', '".$costo_danios."');";
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
        isset($_REQUEST['id_incidente']) &&
        isset($_REQUEST['tipo']) &&
        isset($_REQUEST['descripcion']) &&
        isset($_REQUEST['direccion']) &&
        isset($_REQUEST['gravedad']) &&
        isset($_REQUEST['fecha_hora']) &&
        isset($_REQUEST['personas_lesionadas']) &&
        isset($_REQUEST['costo_danios'])
    ) {
        $id_incidente = $_REQUEST['id_incidente'];
        $tipo = $_REQUEST['tipo'];
        $descripcion = $_REQUEST['descripcion'];
        $direccion = $_REQUEST['direccion'];
        $gravedad = $_REQUEST['gravedad'];
        $fecha_hora = $_REQUEST['fecha_hora'];
        $personas_lesionadas = $_REQUEST['personas_lesionadas'];
        $costo_danios = $_REQUEST['costo_danios'];

        $query = "UPDATE `incidentes` SET 
         `tipo` = '".$tipo."',
         `descripcion` = '".$descripcion."', 
         `direccion` = '".$direccion."', 
         `gravedad` = '".$gravedad."', 
         `fecha_hora` = '".$fecha_hora."', 
         `personas_lesionadas` = '".$personas_lesionadas."', 
         `costo_danios` = '".$costo_danios."' 
         WHERE (`id_incidente` = '".$id_incidente."');";

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
    if (isset($_REQUEST['id_incidente'])) {
        $id_incidente = $_REQUEST['id_incidente'];
        $query = "DELETE FROM `incidentes` WHERE (`id_incidente` = '".$id_incidente."');";
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
    $query = "SELECT * FROM incidentes;";
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
    if (isset($_REQUEST['id_incidente'])) {
        $id_incidente = $_REQUEST['id_incidente'];
        $query = "SELECT * FROM incidentes where id_incidente = ".$id_incidente.";";
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
