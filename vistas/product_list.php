<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar producto #
        if(isset($_GET['product_id_del'])){
            require_once "./php/producto_eliminar.php";
        }

        $pagina = (isset($_GET['page']) && $_GET['page'] > 1) ? (int)$_GET['page'] : 1;

        # Entrada producto #
        if(isset($_GET['product_id_entrada'])){
            header("Location: index.php?vista=product_entrada&product_id_entrada=".$_GET['product_id_entrada']);
            exit; // Asegura que el script se detenga después de la redirección
        }
        

        # Salida producto #
        if(isset($_GET['product_id_salida'])){
            header("Location: index.php?vista=product_salida&product_id_salida=".$_GET['product_id_salida']);
            exit; // Asegura que el script se detenga después de la redirección
        }

        $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;
        $producto_id_entrada = (isset($_GET['product_id_entrada'])) ? $_GET['product_id_entrada'] : 0;
        $producto_id_salida = (isset($_GET['product_id_salida'])) ? $_GET['product_id_salida'] : 0;

        $pagina = limpiar_cadena($pagina);
        $url = "index.php?vista=product_list&page=";
        $url_entrada = "index.php?vista=product_entrada&product_id_entrada=$producto_id_entrada&page=";
        $url_salida = "index.php?vista=product_salida&product_id_salida=$producto_id_salida&page=";

        $registros = 15;
        $busqueda = "";

        # Paginador producto #
        require_once "./php/producto_lista.php";
    ?>
</div>
