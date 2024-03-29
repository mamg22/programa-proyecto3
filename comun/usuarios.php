<?php
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';
validar_acceso(PERFIL_ADMINISTRADOR, SUBSISTEMA_TODOS);

$pagina = (int)($_REQUEST['pagina'] ?? 1);
$offset = $pagina - 1;
$item_offset = $offset * ITEMS_POR_PAGINA;

$con = null;
$info_cargada = false;
try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
}

$total = 0;
if ($con) {
    try {
        $stmt = $con->prepare("SELECT id, nombre, cedula, perfil, nombre_perfil
        FROM Vista_usuario
        WHERE subsistema=? AND perfil!=10
        ORDER BY subsistema, id
        LIMIT ?, ?");
        $stmt->bind_param("iii", $_SESSION['subsistema_actual'], $item_offset, $ITEMS_POR_PAGINA);
        $stmt->execute();
        $info_usuarios = $stmt->get_result();

        $stmt = $con->prepare("SELECT count(id) as total
        FROM Vista_usuario
        WHERE subsistema=? AND perfil!=10
        ORDER BY subsistema, id");
        $stmt->bind_param("i", $_SESSION['subsistema_actual']);
        $stmt->execute();
        $total = $stmt->get_result()->fetch_object()->total;

        $info_cargada = true;
    } catch (mysqli_sql_exception $e) {
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_CARGANDO_INFO,
            Mensaje::ERROR
        ));
    }
}

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
        <a id="agg" href='/comun/editar-usuario.php?id=nuevo'> Registrar usuario</a>
        <?= gen_pagination($pagina, $total) ?>
        <div class="element-container">
            <?php
            if ($info_cargada) {
                while ($row = $info_usuarios->fetch_object()) {
            ?>
                    <div class="element">
                        <p class="element-content">
                            <span class="big"><b><?= htmlspecialchars($row->nombre) ?></b></span>
                            <hr />
                            <b>Cédula:</b> <?= htmlspecialchars($row->cedula) ?>
                            <hr />
                            <b>Perfil:</b> <?= htmlspecialchars($row->nombre_perfil) ?>
                            <hr />
                        </p>
                        <div class="element-actions">
                            <a href="/comun/editar-usuario.php?id=<?= $row->id ?>">Modificar</a>
                            <a class='needs-confirm' href="/internal/comun/editar-usuarios.php?modo=eliminar&id=<?= $row->id ?>">Eliminar</a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <?= gen_pagination($pagina, $total) ?>
    </section>
    <div id='popup-container'></div>
</body>

</html>