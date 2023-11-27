<?php
session_start();
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Check connection
if (mysqli_connect_errno()) {
    echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit;
}

$id = $_SESSION["id"];

$sql = "DELETE FROM carrito_compras WHERE ID_Usuario = $id";

if (!mysqli_query($con, $sql)) {
    echo json_encode(array('success' => false, 'message' => 'Error: ' . mysqli_error($con)));
    exit;
}

echo json_encode(array('success' => true, 'message' => 'Product added successfully'));
?>