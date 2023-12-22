<?php
$categoria_id = isset($categoria_id) ? $categoria_id : 0;
$proveedor_id = isset($proveedor_id) ? $proveedor_id : 0;


$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";

$campos = "producto.producto_id, producto.producto_codigo, producto.producto_nombre, producto.producto_precio, producto.producto_stock, producto.producto_foto, producto.categoria_id, producto.usuario_id, categoria.categoria_id, categoria.categoria_nombre, usuario.usuario_id, usuario.usuario_nombre, usuario.usuario_apellido, producto.producto_marca, producto.proveedor_id, proveedor.proveedor_id, proveedor.proveedor_nombre";

if (isset($busqueda) && $busqueda != "") {
    $consulta_datos = "SELECT $campos FROM producto 
                      INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
                      INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
                      LEFT JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
                      WHERE producto.producto_codigo LIKE '%$busqueda%' OR producto.producto_nombre LIKE '%$busqueda%' 
                      ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(producto_id) FROM producto 
                      LEFT JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
                      WHERE producto.producto_codigo LIKE '%$busqueda%' OR producto.producto_nombre LIKE '%$busqueda%'";
} elseif ($categoria_id > 0 || $proveedor_id > 0) {
    if ($categoria_id > 0) {
        $consulta_datos = "SELECT $campos FROM producto 
                          INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
                          INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
                          LEFT JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
                          WHERE producto.categoria_id='$categoria_id' 
                          ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(producto_id) FROM producto 
                          LEFT JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
                          WHERE categoria_id='$categoria_id'";
    } elseif ($proveedor_id > 0) {
        // Consulta para filtrar por proveedor
        $consulta_datos = "SELECT $campos FROM producto 
                          INNER JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
                          INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
                          LEFT JOIN categoria ON producto.categoria_id = categoria.categoria_id 
                          WHERE producto.proveedor_id='$proveedor_id' 
                          ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(producto_id) FROM producto 
                          LEFT JOIN categoria ON producto.categoria_id = categoria.categoria_id 
                          WHERE proveedor_id='$proveedor_id'";
    }
} else {
    $consulta_datos = "SELECT $campos FROM producto 
                      INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
                      INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
                      LEFT JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
                      ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(producto_id) FROM producto 
                      LEFT JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id";
}

$conexion = conexion();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int) $total->fetchColumn();

$Npaginas = ceil($total / $registros);



if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;

    // Inicia la tabla
    $tabla .= '
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Marca</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Registrado por</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    ';

    foreach ($datos as $rows) {
        $tabla .= '
            
            <tr>
                <td>' . $contador . '</td>
                </td>
                <td>' . $rows['producto_nombre'] . '</td>
                <td>$' . number_format($rows['producto_precio'], 0, '', '') . '</td>
                <td>' . $rows['producto_stock'] . '</td>
                <td>' . $rows['producto_marca'] . '</td>
                <td>' . $rows['categoria_nombre'] . '</td>
                <td>' . $rows['proveedor_nombre'] . '</td>
                <td>' . $rows['usuario_nombre'] . ' ' . $rows['usuario_apellido'] . '</td>
                <td>
                <div class="buttons is-pulled-left">
                    <a href="' . $url . $pagina . '&product_id_entrada=' . $rows['producto_id'] . '" class="button is-link is-rounded is-small">Entrada</a>
                </div>
                <div class="buttons is-pulled-left">
                    <a href="' . $url . $pagina . '&product_id_salida=' . $rows['producto_id'] . '" class="button is-warning is-rounded is-small">Salida</a>
                </div>

                    <div class="buttons is-right">
                        <a href="'.$url.$pagina.'&product_id_del='.$rows['producto_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </div>

                </td>
            </tr>
        ';
        $contador++;
    }

    // Cierra la tabla
    $tabla .= '
            </tbody>
        </table>
    ';

    $pag_final = $contador - 1;

    // Muestra la tabla y el paginador
    echo $tabla;

    echo '<p class="has-text-right">Mostrando productos <strong>' . $inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';

    echo paginador_tablas($pagina, $Npaginas, $url, 7);
} else {
    if ($total >= 1) {
        $tabla .= '
            <p class="has-text-centered" >
                <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic acá para recargar el listado
                </a>
            </p>
        ';
    } else {
        $tabla .= '
            <p class="has-text-centered" >No hay registros en el sistema</p>
        ';
    }

    // Muestra el mensaje cuando no hay registros
    echo $tabla;
}

$conexion = null;
?>
<?php
// ... (código anterior)

