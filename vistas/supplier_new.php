<div class="container is-fluid mb-6">
    <h1 class="title">Proveedores</h1>
    <h2 class="subtitle">Nuevo proveedor</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/proveedor_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="proveedor_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Teléfono</label>
                    <input class="input" type="tel" name="proveedor_telefono" pattern="[0-9]{1,25}" maxlength="25" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Correo</label>
                    <input class="input" type="email" name="proveedor_correo" maxlength="70">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Dirección</label>
                    <input class="input" type="text" name="proveedor_direccion" maxlength="150">
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Fecha</label>
                    <input class="input" type="date" name="proveedor_fecha" required>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>
