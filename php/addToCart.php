<?php
session_start();
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Check connection
if (mysqli_connect_errno()) {
    echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit;
}

$id = $_SESSION["id"];
$productId = mysqli_real_escape_string($con, $_POST['productId']);

$sql = "INSERT INTO carrito_compras (ID_Usuario, ID_Producto) VALUES ('$id', '$productId');";

if (!mysqli_query($con, $sql)) {
    echo json_encode(array('success' => false, 'message' => 'Error: ' . mysqli_error($con)));
    exit;
}

echo json_encode(array('success' => true, 'message' => 'Product added successfully'));
?>