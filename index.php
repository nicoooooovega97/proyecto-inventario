<?php require "./inc/session_start.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "./inc/head.php"; ?>
    <style>
        body {
            padding-top: 56px;
            text-align: center;
        }

        .dashboard-container {
            position: relative;
            /* Añadido para posicionar los widgets relativos al contenedor */
            margin: auto;
            width: 100%;
            margin-top: 30px !important;
        }

        .widget {
            border: 1px solid #ddd;
            padding: 8px;
            margin-bottom: 15px;
            background-color: #f3f3f3;
            /* Cambia el color de fondo */
            width: 30%;
            display:inline-block;
            /* Ajusta el ancho según sea necesario */
            /* Añadido para posicionar los widgets absolutamente */
        }

        .widget:nth-child(1) {
            top: 0;
            left: 0;
        }

        .widget:nth-child(2) {
            top: 0;
            left: 220px;
            /* Ajusta la separación horizontal */
        }

        .widget:nth-child(3) {
            top: 0;
            left: 440px;
            /* Ajusta la separación horizontal */
        }

        /* Agrega más reglas nth-child según sea necesario */

        /* Agrega estilos adicionales según sea necesario */
    </style>
</head>

<body>

<?php

if (!isset($_GET['vista']) || $_GET['vista'] == "") {
    $_GET['vista'] = "login";
}


if (is_file("./vistas/" . $_GET['vista'] . ".php") && $_GET['vista'] != "login" && $_GET['vista'] != "404") {
    // Verifica la sesión
    if (!isset($_SESSION['id']) || empty($_SESSION['id']) || !isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
        include "./vistas/logout.php";
        exit();
    }

    // Incluye la barra de navegación
    include "./inc/navbar.php";
    include "./vistas/" . $_GET['vista'] . ".php";

    include "./inc/script.php";

} else {
    if ($_GET['vista'] == "login") {
        include "./vistas/login.php";
    }
}
