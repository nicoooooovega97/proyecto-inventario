<?php
$modulo_buscador = limpiar_cadena($_POST['modulo_buscador']);
$modulos = ["usuario", "categoria", "producto", "proveedor"];

if (in_array($modulo_buscador, $modulos)) {
    $modulos_url = [
        "usuario" => "user_search",
        "categoria" => "category_search",
        "producto" => "product_search",
        "proveedor" => "supplier_search"
    ];

    $modulos_url = $modulos_url[$modulo_buscador];

    $modulo_buscador = "busqueda_" . $modulo_buscador;

    # Iniciar busqueda #
    if (isset($_POST['txt_buscador'])) {
        $txt = limpiar_cadena($_POST['txt_buscador']);

        if ($txt == "") {
            echo '<div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Introduce el término de búsqueda
                </div>';
        } else {
            if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}", $txt)) {
                echo '<div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El término de búsqueda no coincide con el formato solicitado
                    </div>';
            } else {
                $_SESSION[$modulo_buscador] = $txt;
                echo '<script>window.location.href = "index.php?vista=' . $modulos_url . '";</script>';
                exit();
            }
        }
    }

    # Eliminar busqueda #
    if (isset($_POST['eliminar_buscador'])) {
        unset($_SESSION[$modulo_buscador]);
        echo '<script>window.location.href = "index.php?vista=' . $modulos_url . '";</script>';
        exit();
    }

} else {
    echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No podemos procesar la petición
        </div>';
}
?>
