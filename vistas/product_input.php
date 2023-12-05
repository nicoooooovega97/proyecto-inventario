<div class="container is-fluid mb-6">
    <h1 class="title">Prductos</h1>
    <h2 class="subtitle">Lista de productos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar proveedor #
        if(isset($_GET['proveedor_id_del'])){
            require_once "./php/producto_lista.php"; // Cambiado a proveedor_entrada.php
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }
        $proveedro_id = (isset($_GET['product_id'])) ? $_GET['product_id'] : 0;


        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=productos&page=";
        $registros=15;
        $busqueda="";

        # Paginador proveedores #
        require_once "./php/producto_lista.php";
    ?>
</div>
