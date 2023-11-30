<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";
$proveedor_id = (isset($_GET['proveedor_id'])) ? $_GET['proveedor_id'] : 0;

if (isset($busqueda) && $busqueda != "") {
    $consulta_datos = "SELECT * FROM proveedor WHERE proveedor_nombre LIKE '%$busqueda%' OR proveedor_telefono LIKE '%$busqueda%' OR proveedor_correo LIKE '%$busqueda%' OR proveedor_direccion LIKE '%$busqueda%' OR proveedor_fecha LIKE '%$busqueda%' ORDER BY proveedor_nombre ASC LIMIT $inicio,$registros";
    $consulta_total = "SELECT COUNT(proveedor_id) FROM proveedor WHERE proveedor_nombre LIKE '%$busqueda%' OR proveedor_telefono LIKE '%$busqueda%' OR proveedor_correo LIKE '%$busqueda%' OR proveedor_direccion LIKE '%$busqueda%' OR proveedor_fecha LIKE '%$busqueda%'";
} else {
    $consulta_datos = "SELECT * FROM proveedor ORDER BY proveedor_nombre ASC LIMIT $inicio,$registros";
    $consulta_total = "SELECT COUNT(proveedor_id) FROM proveedor";
}

$conexion = conexion();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int)$total->fetchColumn();

$Npaginas = ceil($total / $registros);

$tabla .= '
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Dirección</th>
                    <th>Fecha</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
';

if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;

    foreach ($datos as $rows) {
        $tabla .= '
            <tr class="has-text-centered">
                <td>' . $contador . '</td>
                <td>' . $rows['proveedor_nombre'] . '</td>
                <td>' . $rows['proveedor_telefono'] . '</td>
                <td>' . $rows['proveedor_correo'] . '</td>
                <td>' . $rows['proveedor_direccion'] . '</td>
                <td>' . $rows['proveedor_fecha'] . '</td>
                <td>
                    <a href="index.php?vista=supplier_update&supplier_id_up=' . $rows['proveedor_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="' . $url . $pagina . '&supplier_id_del=' . $rows['proveedor_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
        ';
        $contador++;
    }

    $pag_final = $contador - 1;
} else {
    if ($total >= 1) {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="7">
                    <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    } else {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
    }
}

$tabla .= '</tbody></table></div>';

if ($total > 0 && $pagina <= $Npaginas) {
    $tabla .= '<p class="has-text-right">Mostrando proveedores <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
}

$conexion = null;
echo $tabla;

if ($total >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
?>
