<?php

/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

session_start();

require_once(dirname(__FILE__).'/proc/classes/auth.php');
require_once(dirname(__FILE__).'/config.php');

?>

<script type="text/javascript">
    var GLOBAL_domain = "<?php echo $GLOBALS['domain']; ?>";
</script>

<!DOCTYPE html>
<head>
    <title>CAVI System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="styles1.0/main.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="scripts1.0/toolbox.js"></script>
</head>

<div id="headerNavigation" class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <a class="navbar-brand brand" id="nav_brand"><?php echo $datos["nombre"]; ?></a>
        <ul class="nav">
            <li class="nav_lista_link" id="nav_datos"><a href="<?php echo $GLOBALS['domain']; ?>/datos.php">Datos</a></li>
            <li class="nav_lista_link" id="nav_lista_socios"><a href="<?php echo $GLOBALS['domain']; ?>">Socios</a></li>
            <li class="nav_lista_link" id="nav_lista_pagos"><a href="<?php echo $GLOBALS['domain']; ?>/lista_pagos.php">Pagos</a></li>
            <li class="nav_lista_link" id="nav_lista_gastos"><a href="<?php echo $GLOBALS['domain']; ?>/lista_gastos.php">Caja</a></li>
            <li class="nav_lista_link" id="nav_lista_estadisticas"><a href="<?php echo $GLOBALS['domain']; ?>/estadisticas.php">Estadisticas</a></li>
            <li class="nav_lista_link" id="nav_lista_entregas"><a href="<?php echo $GLOBALS['domain']; ?>/lista_entregas.php">Entregas</a></li>
            <li class="nav_lista_link" id="nav_lista_admins"><a href="<?php echo $GLOBALS['domain']; ?>/lista_admins.php">Admin</a></li>
            <!--            <li class="nav_lista_link" id="nav_informes"><a href="--><?php //echo $GLOBALS['domain']; ?><!--/informes.php">Informes</a></li>-->
        </ul>

        <a id="nav_logout" href="#" onClick="Toolbox.Logout(); return false;">salir</a>
        <p id="admin_header_name"><?php echo Auth::get_admin_nombre() . " | "?></p>
        <img id="nav_loader" src="images/loader.gif">
    </div>
</div>
