<?php
session_start();

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo json_encode(['error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()]);
    exit;
}

// Obtiene la fecha y hora actual en el formato 'YYYY-MM-DD HH:MI:SS'
$fecha_actual = date('Y-m-d H:i:s');

$id = $_SESSION["id"];

// Realizar la consulta para obtener los datos de los productos y del carrito
$query = "
SELECT ID_Producto FROM carrito_compras WHERE ID_USUARIO = $id;
";
$result = mysqli_query($con, $query);

// Verificar si se obtuvieron resultados
if (!$result) {
    echo json_encode(['error' => 'No se pudieron obtener los datos de los productos.']);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    // Insertar en historial_compras
    $idProducto = $row['ID_Producto'];

    $queryInsert = "INSERT INTO historial_compras (ID_Producto, ID_Usuario, Fecha_Compra) VALUES ($idProducto, $id, '$fecha_actual')";
    mysqli_query($con, $queryInsert);
    
    // Actualizar la cantidad de productos en el inventario
    $queryUpdate = "UPDATE productos SET Cantidad_Almacen = Cantidad_Almacen - 1 WHERE ID_Producto = $idProducto";
    mysqli_query($con, $queryUpdate);
}

$del = "DELETE FROM carrito_compras WHERE id_usuario = $id";
$result = mysqli_query($con,$del);

// Cerrar la conexión a la base de datos
mysqli_close($con);
header('Location: /pruebas/index.php');
exit;
?>