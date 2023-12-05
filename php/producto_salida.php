
<?php

require_once "main.php";





/*== Almacenando id ==*/
$producto_id_salida = limpiar_cadena($_POST['producto_id']);

/*== Verificando producto ==*/
$check_producto = conexion();
$check_producto = $check_producto->query("SELECT * FROM producto WHERE producto_id='$producto_id_salida'");

if ($check_producto->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El producto no existe en el sistema
        </div>
    ';
    exit();
} else {
    $datos = $check_producto->fetch();
}
$check_producto = null;
$nuevo_stock = isset($datos['stock_nuevo']) ? $datos['stock_nuevo'] : '';
/*== Almacenando datos ==*/
$nombre = limpiar_cadena($_POST['producto_nombre']);
$precio = limpiar_cadena($_POST['producto_precio']);
$marca = limpiar_cadena($_POST['producto_marca']);
$categoria = limpiar_cadena($_POST['producto_categoria']);
$usuario = limpiar_cadena($_POST['producto_usuario']);
$proveedor = limpiar_cadena($_POST['producto_proveedor']);
$fecha = limpiar_cadena($_POST['producto_fecha']);
$stock_nuevo = $_POST['stock_nuevo'] ?? null;

/*== Verificando campos obligatorios ==*/
if ($nombre == "" || $precio == "" || $marca == "" || $categoria == "" || $proveedor == "" || $fecha == ""|| $usuario == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("[0-9.]{1,25}", $precio)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El PRECIO no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $marca)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La MARCA no coincide con el formato solicitado
        </div>
    ';
    exit();
}

/*== Verificando nombre ==*/
if ($nombre != $datos['producto_nombre']) {
    $check_nombre = conexion();
    $check_nombre = $check_nombre->query("SELECT producto_nombre FROM producto WHERE producto_nombre='$nombre'");
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

/*== Verificando categoria ==*/
if ($categoria != $datos['categoria_id']) {
    $check_categoria = conexion();
    $check_categoria = $check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
    if ($check_categoria->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La categoría seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_categoria = null;
}
/*== Verificando usuario ==*/

if ($usuario != $datos['usuario_id']) {
    $check_usuario = conexion();
    $check_usuario= $check_usuario->query("SELECT usuario_id FROM usuario WHERE usuario_id='$usuario'");
    if ($check_usuario->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                el usuario seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_usuario = null;
}

/*== Actualizando datos ==*/
$nuevo_stock = calcularStockSalida($datos['producto_stock'], $stock_nuevo);

$actualizar_producto = conexion();
$actualizar_producto = $actualizar_producto->prepare("UPDATE producto 
                                                      SET producto_nombre=:nombre, 
                                                          producto_precio=:precio, 
                                                          producto_stock=:nuevo_stock, 
                                                          producto_marca=:marca, 
                                                          categoria_id=:categoria, 
                                                          proveedor_id=:proveedor,
                                                          producto_fecha=:fecha,
                                                          usuario_id=:usuario 
                                                      WHERE producto_id=:id");

$marcadores = [
    ":nombre" => $nombre,
    ":precio" => $precio,
    ":nuevo_stock" => $nuevo_stock,
    ":marca" => $marca,
    ":categoria" => $categoria,
    ":proveedor" => $proveedor,
    ":fecha" => $fecha,
    ":id" => $producto_id_salida,
    ":usuario" => $usuario
];

if ($actualizar_producto->execute($marcadores)) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡PRODUCTO ACTUALIZADO!</strong><br>
            El producto se actualizó con éxito
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo actualizar el producto,  por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_producto=null;