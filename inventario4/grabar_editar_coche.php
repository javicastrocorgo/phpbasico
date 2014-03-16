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
    $url = "formulario_editar_coche.php";
    header('Location:'.$url);
} else {
    $db = conectaBd();
    $marca= $_SESSION['datos'][0];
    $modelo= $_SESSION['datos'][1];  
    $matricula= $_SESSION['datos'][2];  
    $id = $_SESSION['id'];
    
    $consulta = "UPDATE coches 
    set marca = :marca, 
    modelo=:modelo, 
    matricula=:matricula,
  
    WHERE id=:id";
    
    $resultado = $db->prepare($consulta);
    if ($resultado->execute(array(":marca" => $marca,
        ":modelo" => $modelo, 
        ":matricula" => $matricula, 
        ":id" => $id))) {
                unset($_SESSION['datos']);
                unset($_SESSION['errores']);
                unset($_SESSION['hayErrores']);
                $_SESSION['id'] = 0;
                $url = "listado_software.php";
                header('Location:'.$url);
    } else {
        print "<p>Error al crear el registro.</p>\n";
    }

    $db = null;
}

