<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <title>Administración de usuarios</title>
</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Administración de usuarios</h1>
    <section id="main">
        <button id="agg">Registrar usuario</button>
        <div class="element-container">
            <div class="element">
                <p class="element-content">
                    <span class="big"><b>Usuario1</b></span>
                    <hr/>
                    <b>Cédula:</b> V-27669598
                    <hr/>
                    <b>Subsistema:</b> Cyber
                    <hr/>
                    <b>Perfil:</b> Administrador
                </p>
                <div class="element-actions">
                    <button>Modificar</button>
                    <button>Eliminar</button>
                </div>
            </div>
            <div class="element">
                <p class="element-content">
                    <span class="big"><b>Usuario2</b></span>
                    <hr/>
                    <b>Cédula:</b> V-12315439
                    <hr/>
                    <b>Subsistema:</b> Cyber
                    <hr/>
                    <b>Perfil:</b> Regular
                </p>
                <div class="element-actions">
                    <button>Modificar</button>
                    <button>Eliminar</button>
                </div>
            </div>
        </div>
    </section>
    <div id='popup-container'></div>
</body>
</html>

