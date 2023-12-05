<div class="container is-fluid mb-6">
    <h1 class="title">Proveedores</h1>
    <h2 class="subtitle">Actualizar proveedor</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";

        require_once "./php/main.php";

        $id = (isset($_GET['supplier_id_up'])) ? $_GET['supplier_id_up'] : 0;
        $id = limpiar_cadena($id);

        /* Verificando proveedor */
        $check_proveedor = conexion();
        $check_proveedor = $check_proveedor->query("SELECT * FROM proveedor WHERE proveedor_id='$id'");

        if ($check_proveedor->rowCount() > 0) {
            $datos = $check_proveedor->fetch();
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/proveedor_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">

        <input type="hidden" name="proveedor_id" value="<?php echo $datos['proveedor_id']; ?>" required>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="proveedor_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required value="<?php echo $datos['proveedor_nombre']; ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Teléfono</label>
                    <input class="input" type="tel" name="proveedor_telefono" pattern="[0-9]{9,15}" maxlength="15" value="<?php echo $datos['proveedor_telefono']; ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Correo</label>
                    <input class="input" type="email" name="proveedor_correo" maxlength="50" value="<?php echo $datos['proveedor_correo']; ?>">
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Dirección</label>
                    <input class="input" type="text" name="proveedor_direccion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" value="<?php echo $datos['proveedor_direccion']; ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Fecha</label>
                    <input class="input" type="date" name="proveedor_fecha" value="<?php echo $datos['proveedor_fecha']; ?>">
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Actualizar</button>
        </p>
    </form>
    <?php 
        } else {
            include "./inc/error_alert.php";
        }
        $check_proveedor = null;
    ?>
</div>
