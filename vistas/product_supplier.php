<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos por proveedor</h2>
</div>

<div class="container pb-6 pt-6">
    <?php 
        require_once "./php/main.php";
    ?>
    
    <div class="columns">
        <div class="column is-one-fifth">
            <h2 class="title has-text-centered">Proveedores</h2>
            <?php
                $proveedores=conexion();
                $proveedores = conexion()->query("SELECT * FROM proveedor");

                if($proveedores->rowCount() > 0){
                    $proveedores = $proveedores->fetchAll();

                    foreach($proveedores as $row){
                        echo '<a href="index.php?vista=product_supplier&supplier_id='.$row['proveedor_id'].'" class="button is-link is-inverted is-fullwidth">'.$row['proveedor_nombre'].'</a>';
                    }
                } else {
                    echo '<p class="has-text-centered">No hay proveedores registrados</p>';
                }
                $proveedores=null;
            ?>
        </div>

        <div class="column">
            <?php
                $proveedor_id = (isset($_GET['supplier_id'])) ? $_GET['supplier_id'] : 0;

                $check_proveedor=conexion();
                $check_proveedor = conexion()->query("SELECT * FROM proveedor WHERE proveedor_id='$proveedor_id'");

                if($check_proveedor->rowCount() > 0){
                    $check_proveedor = $check_proveedor->fetch();
                    
                    echo '
                        <h2 class="title has-text-centered">'.$check_proveedor['proveedor_nombre']. '</h2>
                    ';

                   
                    require_once "./php/main.php";

                    # Eliminar producto #
                    if(isset($_GET['product_id_del'])){
                        require_once "./php/producto_eliminar.php";
                    }

                    if(!isset($_GET['page'])){
                        $pagina = 1;
                    } else {
                        $pagina = (int) $_GET['page'];
                        if($pagina <= 1){
                            $pagina = 1;
                        }
                    }

                    $pagina = limpiar_cadena($pagina);
                    $url = "index.php?vista=product_supplier&supplier_id=$proveedor_id&page=";
                    $registros = 15;
                    $busqueda = "";

                    # Paginador producto #
                    require_once "./php/producto_lista.php";
                    
                } else { 
                    echo '<h2 class="has-text-centered title" >Seleccione una proveedor para empezar</h2>';
                }
                $check_proveedor=null;
            ?>
        </div>
    </div>
</div>