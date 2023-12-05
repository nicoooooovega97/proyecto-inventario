<?php
    $supplier_id_del = limpiar_cadena($_GET['supplier_id_del']);


    $check_proveedor = conexion();
    $check_proveedor = $check_proveedor->query("SELECT proveedor_id FROM proveedor WHERE proveedor_id = '$supplier_id_del'");

    if ($check_proveedor->rowCount() == 1) {
        $check_productos = conexion();
        $check_productos = $check_productos->query("SELECT proveedor_id FROM producto WHERE proveedor_id = '$supplier_id_del' LIMIT 1");

        if ($check_productos->rowCount() <= 0) {
            $eliminar_proveedor = conexion();
            $eliminar_proveedor = $eliminar_proveedor->prepare("DELETE FROM proveedor WHERE proveedor_id = :id");

            $eliminar_proveedor->execute([":id" => $supplier_id_del]);

            if ($eliminar_proveedor->rowCount() == 1) {
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡PROVEEDOR ELIMINADO!</strong><br>
                        Los datos del proveedor se eliminaron con éxito
                    </div>
                ';
            } else {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        No se pudo eliminar el proveedor, por favor inténtelo nuevamente
                    </div>
                ';
            }
            $eliminar_proveedor = null;
        } else {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No podemos eliminar el proveedor ya que tiene productos asociados
                </div>
            ';
        }
        $check_productos = null;
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El proveedor que intenta eliminar no existe
            </div>
        ';
    }
    $check_proveedor = null;

