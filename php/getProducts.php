<?php
session_start();

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo json_encode(['error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()]);
    exit;
}

// Realizar la consulta para obtener los datos de los productos y del carrito
$query = "
SELECT P.ID_Producto, P.Nombre, P.Precio, (SELECT Nombre_foto FROM fotos WHERE ID_Producto = P.ID_Producto LIMIT 1) as foto, COALESCE(COUNT(c.ID_Producto), 0) as cantidad, COALESCE(SUM(p.Precio), 0) as totalPrecio FROM productos P LEFT JOIN carrito_compras c ON c.id_usuario = 1 AND c.id_producto = P.ID_Producto GROUP BY P.ID_Producto;
";
$result = mysqli_query($con, $query);

// Verificar si se obtuvieron resultados
if (!$result) {
    echo json_encode(['error' => 'No se pudieron obtener los datos de los productos.']);
    exit;
}

// Obtener los resultados en un array asociativo
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Devolver los resultados en formato JSON
echo json_encode($data);

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>