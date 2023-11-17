<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

	/*== Almacenando datos ==*/

	$nombre=limpiar_cadena($_POST['producto_nombre']);

	$precio=limpiar_cadena($_POST['producto_precio']);
	$stock=limpiar_cadena($_POST['producto_stock']);
    $marca=limpiar_cadena($_POST['producto_marca']);
	$categoria=limpiar_cadena($_POST['producto_categoria']);
    $proveedor=limpiar_cadena($_POST['producto_proveedor']);


	/*== Verificando campos obligatorios ==*/
    if($nombre=="" || $precio=="" || $stock==""  || $marca==""  || $categoria=="" || $proveedor==""  ){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


   

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9.]{1,25}",$precio)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRECIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9]{1,25}",$stock)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El STOCK no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9- ]{1,70}",$marca)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                LA MARCA no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

  

    /*== Verificando nombre ==*/
    $check_nombre=conexion();
    $check_nombre=$check_nombre->query("SELECT producto_nombre FROM producto WHERE producto_nombre='$nombre'");
    if($check_nombre->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
   

    /*== Verificando categoria ==*/
    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
    if($check_categoria->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoría seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_categoria=null;


    /*== Verificando proveedor ==*/
    $check_proveedor=conexion();
    $check_proveedor=$check_proveedor->query("SELECT proveedor_id FROM proveedor WHERE proveedor_id='$proveedor'");
    if($check_proveedor->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El proveedor seleccionado no existe
            </div>
        ';
        exit();
    }
    $check_proveedor=null;

	/*== Guardando datos ==*/
    $guardar_producto=conexion();
    $guardar_producto=$guardar_producto->prepare("INSERT INTO producto(producto_nombre,producto_precio,producto_stock,producto_marca,categoria_id,proveedor_id,usuario_id) VALUES(:nombre,:precio,:stock,:marca,:categoria,:proveedor,:usuario)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":precio"=>$precio,
        ":stock"=>$stock,
        ":marca"=>$marca,
        ":categoria"=>$categoria,
        ":proveedor"=>$proveedor,
        ":usuario"=>$_SESSION['id']
    ];

    $guardar_producto->execute($marcadores);

    if($guardar_producto->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PRODUCTO REGISTRADO!</strong><br>
                El producto se registro con exito
            </div>
        ';
    }
    
    $guardar_producto=null;