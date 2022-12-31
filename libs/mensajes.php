<?php
class Mensaje implements JsonSerializable {
    private string $contenido;
    private string $tipo;

    public const ERROR = 'error';
    public const WARN = 'warn';
    public const OK = 'ok';
    public const INFO = 'info';

    public function contenido() {
        return $this->contenido;
    }

    public function tipo() {
        return $this->tipo;
    }

    public function __construct(string $contenido, string $tipo) {
        $this->contenido = $contenido;
        $this->tipo = $tipo;
    }

    public function jsonSerialize(): mixed {
        return array(
            "contenido" => $this->contenido,
            "tipo" => $this->tipo,
        );
    }
}

function assert_mensajes(): void {
    if (!isset($_SESSION['mensajes']) || !is_array($_SESSION['mensajes'])) {
        $_SESSION['mensajes'] = array();
    }
}

function push_mensaje(Mensaje $mensaje): void {
    assert_mensajes();
    array_push($_SESSION['mensajes'], $mensaje);
}

function pop_mensaje(): Mensaje {
    assert_mensajes();
    return array_pop($_SESSION['mensajes']);
}

function vaciar_mensajes(): void {
    $_SESSION['mensajes'] = array();
}

function inyectar_mensajes(): string {
    assert_mensajes();
    $mensajes = json_encode($_SESSION['mensajes']);
    vaciar_mensajes();
    return <<<HTML
    <script type='text/javascript'>
        var popups = $mensajes;
        setup_popups(popups);
    </script>
    HTML;
}

class Mensajes_comun {
    public const ERR_CONECTANDO_BD = 
    "Ha ocurrido un error al conectar con la base de datos. Por favor, intentelo de nuevo.<br>" .
    "Si el problema persiste, contacte al administrador.";
    public const ERR_NO_AUTORIZADO =
    "Este usuario no está autorizado para acceder a esta función";
    public const ERR_INCOMPLETO =
    "Uno o más campos del formulario están incompletos, ingrese la información completa de nuevo";
}
