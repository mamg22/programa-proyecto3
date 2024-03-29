<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php'; 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <title>Estadísticas: Cyber</title>

</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Sistema de gestión<br>Servicio técnico</h1>
    <h2 class="titulo">Bienvenido, <?= $_SESSION['usuario']->nombre() ?></h2>
    <p class="titulo">Haga click en el menú para<br>ver las opciones disponibles</p>
    <p class="titulo">
        Haga click en los íconos de 
        <span class='help-item fa fa-question-circle fa-lg' 
            help-content='La ayuda se mostrará en una notificación como ésta'></span><br>
        para obtener más información y ayuda.
    </p>
    <div id='popup-container'></div>
</body>
</html>
