<?php
session_start();
require_once 'constantes.php';
require_once 'funciones_bd.php';
    // Estructura: campos del formulario
$_SESSION['datos'] = (isset($_SESSION['datos']))?
            $_SESSION['datos']:Array('','','','');
$_SESSION['errores'] = (isset($_SESSION['errores']))?
            $_SESSION['errores']:Array(FALSE,FALSE,FALSE,FALSE);
$_SESSION['hayErrores'] = (isset($_SESSION['hayErrores']))?
            $_SESSION['hayErrores']:FALSE;

/**
 * Cargar datos para editar
 */

$id = (isset($_REQUEST['id']))?$_REQUEST['id']:0;
$bd = conectaBd();
$consulta = "SELECT * FROM coches WHERE id=".$id;
$resultado = $bd->query($consulta);
if (!$resultado) {
       $url = "error.php?msg_error=Error_Consulta_Editar";
       header('Location:'.$url);
} else { 
       $registro = $resultado->fetch(); 
       if(!$registro) {
           $url = "error.php?msg_error=Error_Registro_Equipo_inexistente";
           header('Location:'.$url);
       } else {
           $_SESSION['datos'][0] = $registro['marca'];
           $_SESSION['datos'][1] = $registro['modelo'];
           $_SESSION['datos'][2] = $registro['matricula'];
       }
}
$_SESSION['id'] = $id;
?>
<html>
    <head>
        <title>Editar Equipo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <div>Datos Editar Equipo</div>
        <form action="grabar_editar_coche.php" method="GET">
            <div>
                <input type="hidden" name="id" 
                value="<?php echo $_SESSION['id']; ?>"/></div>
           
            </div>
            <div>Nombre: <input type="text" name="marca" 
                                value="<?php echo $_SESSION['datos'][0]; ?>"/></div>
            <?php
                if ($_SESSION['errores'][0]) {
                    echo "<div class 'error'>".MSG_ERR_Marca."</div>";
                }
            ?>
            <div>Descripción <input type="text" name="modelo" 
                                value="<?php echo $_SESSION['datos'][1]; ?>"/></div>
            <?php
                if ($_SESSION['errores'][1]) {
                    echo "<div class 'error'>".MSG_ERR_Modelo."</div>";
                }
            ?>
            <div>IP <input type="text" name="matricula" 
                           value="<?php echo $_SESSION['datos'][2]; ?>"/></div>
            <?php
                if ($_SESSION['errores'][2]) {
                    echo "<div class 'error'>".MSG_ERR_Matricula."</div>";
                }
            ?>
            <p><input type="submit" value="Enviar" /></p>
        </form>
    </body>
</html>

