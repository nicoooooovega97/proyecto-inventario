<?php
    require_once "main.php";

    /*== Almacenando datos ==*/
    $nombre = limpiar_cadena($_POST['proveedor_nombre']);
    $telefono = limpiar_cadena($_POST['proveedor_telefono']);
    $correo = limpiar_cadena($_POST['proveedor_correo']);
    $direccion = limpiar_cadena($_POST['proveedor_direccion']);
    $fecha = limpiar_cadena($_POST['proveedor_fecha']);

    /*== Verificando campos obligatorios ==*/
    if ($nombre == "" || $telefono == "" || $correo == "" || $direccion == "" || $fecha == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos ==*/
    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $nombre)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El CORREO no es válido
            </div>
        ';
        exit();
    }

    /*== Verificando nombre ==*/
    $check_nombre = conexion();
    $check_nombre = $check_nombre->query("SELECT proveedor_nombre FROM proveedor WHERE proveedor_nombre='$nombre'");
    if ($check_nombre->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre = null;

    /*== Guardando datos ==*/
    $guardar_proveedor = conexion();
    $guardar_proveedor = $guardar_proveedor->prepare("INSERT INTO proveedor(proveedor_nombre, proveedor_telefono, proveedor_correo, proveedor_direccion, proveedor_fecha) VALUES(:nombre, :telefono, :correo, :direccion, :fecha)");

    $marcadores = [
        ":nombre" => $nombre,
        ":telefono" => $telefono,
        ":correo" => $correo,
        ":direccion" => $direccion,
        ":fecha" => $fecha
    ];

    $guardar_proveedor->execute($marcadores);

    if ($guardar_proveedor->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡PROVEEDOR REGISTRADO!</strong><br>
                El proveedor se registró con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar el proveedor, por favor inténtelo nuevamente
            </div>
        ';
    }
    $guardar_proveedor = null;

    

