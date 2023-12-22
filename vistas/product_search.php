<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Buscar producto</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        if(isset($_POST['modulo_buscador'])){
            require_once "./php/buscador.php";
        }

        if(!isset($_SESSION['busqueda_producto']) && empty($_SESSION['busqueda_producto'])){
    ?>
    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="producto">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" >Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php }else{ ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="producto"> 
                <input type="hidden" name="eliminar_buscador" value="producto">
                <p>Estas buscando <strong>“<?php echo $_SESSION['busqueda_producto']; ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php
    ob_start(); // Start output buffering
    require_once "./php/main.php";
            # Eliminar producto #
if (isset($_GET['product_id_del'])) {
    require_once "./php/producto_eliminar.php";
}

$pagina = (isset($_GET['page']) && $_GET['page'] > 1) ? (int)$_GET['page'] : 1;

# Entrada producto #
if (isset($_GET['product_id_entrada'])) {
    echo '<script>window.location.href = "index.php?vista=product_entrada&product_id_entrada=' . $_GET['product_id_entrada'] . '";</script>';
    ob_end_flush(); // Ensure output buffer is flushed before redirection
    exit; // Ensure script stops after redirection
}

# Salida producto #
if (isset($_GET['product_id_salida'])) {
    echo '<script>window.location.href = "index.php?vista=product_salida&product_id_salida=' . $_GET['product_id_salida'] . '";</script>';
    ob_end_flush(); // Ensure output buffer is flushed before redirection
    exit; // Ensure script stops after redirection
}

            $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;
            $producto_id_entrada = (isset($_GET['product_id_entrada'])) ? $_GET['product_id_entrada'] : 0;
            $producto_id_salida = (isset($_GET['product_id_salida'])) ? $_GET['product_id_salida'] : 0; 
            $pagina=limpiar_cadena($pagina);
            $url="index.php?vista=product_search&page="; /* <== */
            $url_entrada = "index.php?vista=product_entrada&product_id_entrada=$producto_id_entrada&page=";
            $url_salida = "index.php?vista=product_salida&product_id_salida=$producto_id_salida&page=";
            $registros=15;
            $busqueda=$_SESSION['busqueda_producto']; /* <== */

            # Paginador producto #
            require_once "./php/producto_lista.php";
        } 
    ?>
</div>