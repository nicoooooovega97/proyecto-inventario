<?php
require_once "main.php";

/* Almacenando id */
$id = limpiar_cadena($_POST['proveedor_id']);

/* Verificando proveedor */
$check_proveedor = conexion();
$check_proveedor = $check_proveedor->query("SELECT * FROM proveedor WHERE proveedor_id='$id'");

if ($check_proveedor->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El proveedor no existe en el sistema
        </div>
    ';
    exit();
} else {
    $datos = $check_proveedor->fetch();
}
$check_proveedor = null;

/* Almacenando datos */
$nombre = limpiar_cadena($_POST['proveedor_nombre']);

/* Verificando campos obligatorios */
if ($nombre == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}

/* Verificando integridad de los datos */
if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

/* Recogiendo datos adicionales del formulario o estableciendo valores predeterminados */
$telefono = limpiar_cadena($_POST['proveedor_telefono']);
$correo = limpiar_cadena($_POST['proveedor_correo']);
$direccion = limpiar_cadena($_POST['proveedor_direccion']);
$fecha = limpiar_cadena($_POST['proveedor_fecha']);

/* Verificando nombre */
if ($nombre != $datos['proveedor_nombre']) {
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
}

/* Actualizar datos */
$actualizar_proveedor = conexion();
$actualizar_proveedor = $actualizar_proveedor->prepare("UPDATE proveedor SET proveedor_nombre=:nombre, proveedor_telefono=:telefono, proveedor_correo=:correo, proveedor_direccion=:direccion, proveedor_fecha=:fecha WHERE proveedor_id=:id");

$marcadores = [
    ":nombre" => $nombre,
    ":telefono" => $telefono,
    ":correo" => $correo,
    ":direccion" => $direccion,
    ":fecha" => $fecha,
    ":id" => $id
];

if ($actualizar_proveedor->execute($marcadores)) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡PROVEEDOR ACTUALIZADO!</strong><br>
            El proveedor se actualizó con éxito
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo actualizar el proveedor, por favor intente nuevamente
        </div>
    ';
}
$actualizar_proveedor = null;
?>
