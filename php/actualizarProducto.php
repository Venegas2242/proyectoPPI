<?php
session_start();
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);
$usuario = $_SESSION["user"];
$id = $_SESSION["id"];

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario
    $idProducto = $_POST["id_producto"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $cantidadAlmacen = $_POST["cantidad"];
    $fabricante = $_POST["fabricante"];
    $origen = $_POST["origen"];

    $update = "UPDATE `productos` SET `Nombre`='$nombre',`Descripcion`='$descripcion',`Precio`='$precio',`Cantidad_Almacen`='$cantidadAlmacen',`Fabricante`='$fabricante',`Origen`='$origen' WHERE ID_Producto = $idProducto";

    if (mysqli_query($con, $update)) {
        // La consulta fue exitosa
        header("Location: modificarProducto.php");
        exit;
    } else {
        // Error en la consulta
        echo "Error en la actualización: " . mysqli_error($con);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>