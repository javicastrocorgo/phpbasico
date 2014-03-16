<?php
session_start();
require_once 'constantes.php';
    // Estructura: campos del formulario
$_SESSION['datos'] = (isset($_SESSION['datos']))?
            $_SESSION['datos']:Array('','','','');
$_SESSION['errores'] = (isset($_SESSION['errores']))?
            $_SESSION['errores']:Array(FALSE,FALSE,FALSE,FALSE);
$_SESSION['hayErrores'] = (isset($_SESSION['hayErrores']))?
            $_SESSION['hayErrores']:FALSE;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <title>Nuevo Coche</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <div>Datos Nuevo Coche</div>
        <form action="grabar_nuevo_coche.php" method="GET">
            <div>Marca: <input type="text" name="marca" 
                                value="<?php echo $_SESSION['datos'][0]; ?>"/></div>
            <?php
                if ($_SESSION['errores'][0]) {
                    echo "<div class 'error'>".MSG_ERR_NOMBRE."</div>";
                }
            ?>
            <div>Modelo <input type="text" name="modelo" 
                                value="<?php echo $_SESSION['datos'][1]; ?>"/></div>
            <?php
                if ($_SESSION['errores'][1]) {
                    echo "<div class 'error'>".MSG_ERR_DESC."</div>";
                }
            ?>
            <div>Matricula <input type="text" name="matricula" 
                           value="<?php echo $_SESSION['datos'][2]; ?>"/></div>
            <?php
                if ($_SESSION['errores'][2]) {
                    echo "<div class 'error'>".MSG_ERR_IP."</div>";
                }
            ?>
            <p><input type="submit" value="Enviar" /></p>
        </form>
    </body>
</html>

