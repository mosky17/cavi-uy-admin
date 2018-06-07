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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="styles1.0/main.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="scripts1.0/toolbox.js"></script>
    <script src="scripts1.0/jquery.mask.js"></script>

</head>

<nav id="headerNavigation" class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #333366;">
        <a class="navbar-brand" id="nav_brand">
            <img src="images/logo_cavi_small.png">
        </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="<?php echo $GLOBALS['domain']; ?>">Socios <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="<?php echo $GLOBALS['domain']; ?>/lista_pagos.php">Pagos</a>
                    <a class="nav-item nav-link" href="<?php echo $GLOBALS['domain']; ?>/lista_gastos.php">Caja</a>
                    <a class="nav-item nav-link" href="<?php echo $GLOBALS['domain']; ?>/lista_admins.php">Admin</a>
                </div>
    <div class="navbar-nav" style="margin: 0 0 0 auto;">
        <p id="admin_header_name" class="nav-link"><?php echo Auth::get_admin_nombre() . " | "?></p>
        <a id="nav_logout" class="nav-link" href="#" onClick="Toolbox.Logout(); return false;">salir</a>
        <img id="nav_loader" src="images/loader.gif">
    </div>
            </div>
            </nav>
