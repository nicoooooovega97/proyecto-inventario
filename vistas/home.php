<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <!-- Include any additional head elements, such as stylesheets or scripts -->
</head>
<body>

<div class="container is-fluid">
    <h1 class="title">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h1>
    <h2 class="subtitle">Inventario Cafe Energia </h2>
</div>
<div class="container is-flex">
    <img src="img/bienvenida.jpg" alt="Descripción de la imagen" class="is-fullwidth" style="margin-top:30px;">
</div>
<?php 
// Conexión a la base de datos (ajusta los detalles según tu configuración)
$servername = "https://cafeenergia.cl/";
$username = "root";
$password = "";
$dbname = "cca97369_inventario";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los productos más utilizados
$queryProductosMasUtilizados = "SELECT producto_nombre, producto_stock FROM producto ORDER BY producto_stock DESC LIMIT 5";
$resultProductosMasUtilizados = $conn->query($queryProductosMasUtilizados);



// Consulta para obtener los productos con menos stock
$queryProductosMenosStock = "SELECT producto_nombre, producto_stock FROM producto ORDER BY producto_stock ASC LIMIT 5";
$resultProductosMenosStock = $conn->query($queryProductosMenosStock);

// Consulta para obtener los usuarios recientemente añadidos
$queryUsuarioRecientes = "SELECT usuario_id, usuario_nombre FROM usuario ORDER BY usuario_id DESC LIMIT 5";
$resultUsuarioRecientes = $conn->query($queryUsuarioRecientes);
// Consulta para obtener los productos recientemente añadidos
$queryProductosRecientes = "SELECT producto_nombre, producto_fecha, usuario_id FROM producto ORDER BY producto_fecha DESC LIMIT 5";
$resultProductosRecientes = $conn->query($queryProductosRecientes);
?>


<!-- Contenido del dashboard -->
<div class="dashboard-container">
    <div class="widget">
        <h2>Productos con mayor stock</h2>
        <ul>
            <?php
            while ($row = $resultProductosMasUtilizados->fetch_assoc()) {
                echo "<li>{$row['producto_nombre']} - Utilizados: {$row['producto_stock']}</li>";
            }
            ?>
        </ul>
    </div>

    <div class="widget">
        <h2>Productos Recientemente Modificados</h2>
        <ul>
            <?php
            while ($row = $resultProductosRecientes->fetch_assoc()) {
                // Fetching user details who added or removed stock
                $usuario = $conn->query("SELECT usuario_nombre FROM usuario WHERE usuario_id = {$row['usuario_id']}")->fetch_assoc();

                echo "<li>{$row['producto_nombre']} - fecha: {$row['producto_fecha']} - Usuario: {$usuario['usuario_nombre']}</li>";
            }
            ?>
        </ul>
    </div>

   

    <div class="widget">
        <h2>Productos con Menos Stock</h2>
        <ul>
            <?php
            while ($row = $resultProductosMenosStock->fetch_assoc()) {
                echo "<li>{$row['producto_nombre']} - Stock: {$row['producto_stock']}</li>";
            }
            ?>
        </ul>
    </div>
</div>

<?php include "./inc/script.php"; ?>

</body>
</html>