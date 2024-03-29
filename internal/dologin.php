<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';


$input_nombre = $_REQUEST['nombre'];
$input_clave = $_REQUEST['clave'];
if (empty($input_nombre) || empty($input_clave)) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_INCOMPLETO,
        Mensaje::ERROR
    ));
    header("Location: /login.php");
    exit();
}

try {
    $con = conectar_bd();
}
catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
    header("Location: /login.php");
    exit();
}

try {
    $stmt = $con->prepare("SELECT id, nombre, clave, subsistema, perfil
                               FROM Vista_usuario
                               WHERE nombre=?");
    $stmt->bind_param("s", $input_nombre);
    $stmt->execute();
    $stmt->bind_result($id, $nombre, $clave, $subsistema, $perfil);
    $stmt->fetch();
}
catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        "Ha ocurrido un error al iniciar sesión. Por favor, intentelo de nuevo.<br>" .
        "Si el problema persiste, contacte al administrador.",
        Mensaje::ERROR
    ));
    header("Location: /login.php");
    exit();
}


if (isset($id) && password_verify($input_clave, $clave)) {
    $_SESSION['usuario'] = new Usuario($id, $nombre, $perfil, $subsistema);

    switch ($subsistema) {
        case SUBSISTEMA_TODOS:
        case SUBSISTEMA_CYBER:
            $_SESSION['subsistema_actual'] = SUBSISTEMA_CYBER;
            header("Location: /cyber/menu-principal.php");
            break;
        case SUBSISTEMA_SERVICIO:
            $_SESSION['subsistema_actual'] = SUBSISTEMA_SERVICIO;
            header("Location: /tecnico/menu-principal.php");
            break;
    }
    exit();
}
else {
    push_mensaje(new Mensaje(
        "Nombre de usuario o contraseña incorrecto.<br>Por favor, intentelo de nuevo",
        Mensaje::WARN,
    ));
    header("Location: /login.php");
    exit();
}
