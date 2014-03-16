<?php
session_start();
require_once 'funciones_bd.php';
require_once 'funciones_validar.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function validarDatosRegistro() {
    // Recuperar datos Enviados desde formulario_nuevo_equipo.php
    $datos = Array();
    $datos[0] = (isset($_REQUEST['marca']))?
            $_REQUEST['marca']:"";
    $datos[1] = (isset($_REQUEST['modelo']))?
            $_REQUEST['modelo']:"";
    $datos[2] = (isset($_REQUEST['matricula']))?
            $_REQUEST['matricula']:"";
 
    //-----validar ---- //
    $errores = Array();
    $errores[0] = !validarMarca($datos[0]);
    $errores[1] = !validarModelo($datos[1]);
    $errores[2] = !validarMatricula($datos[2]);
    
    // ----- Asignar a variables de Sesión ----//
    $_SESSION['datos'] = $datos;
    $_SESSION['errores'] = $errores;  
    $_SESSION['hayErrores'] = 
            ($errores[0] || $errores[1] ||
             $errores[2]);
    
}


// PRINCIPAL //
validarDatosRegistro();
if ($_SESSION['hayErrores']) {
    $url = "formulario_nuevo_coche.php";
    header('Location:'.$url);
} else {
    $db = conectaBd();
    $consulta = "INSERT INTO coches (marca, modelo, matricula)
    VALUES ('"
           .$_SESSION['datos'][0]."', '"
           .$_SESSION['datos'][1]."', '"
           .$_SESSION['datos'][2]."')";
//    print_r($consulta);
            $result = $db->prepare($consulta);
$result->execute();
    if ($db->prepare($consulta)) {
           $url = "grabacion_ok.php";
           header('Location:'.$url);
    } else {
            $url = "error.php?msg_error=Error_BD";
            header('Location:'.$url);
    }
    $db = null;
}

