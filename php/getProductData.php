<?php
session_start();

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit;
}

$productId = mysqli_real_escape_string($con, $_GET['productId']);
$id = $_SESSION["id"];

$query = "
    SELECT P.ID_Producto, P.Nombre, P.Precio,
           (SELECT Nombre_foto FROM fotos WHERE ID_Producto = P.ID_Producto LIMIT 1) as foto,
           COALESCE(COUNT(c.ID_Producto), 0) as cantidad,
           COALESCE(SUM(p.Precio), 0) as totalPrecio
    FROM productos P
    LEFT JOIN carrito_compras c ON c.id_usuario = $id AND c.id_producto = P.ID_Producto
    WHERE P.ID_Producto = $productId
    GROUP BY P.ID_Producto
    HAVING cantidad > 0
";
$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode(array('success' => false, 'message' => 'Failed to get product data.'));
    exit;
}

$row = mysqli_fetch_assoc($result);
echo json_encode(array('success' => true, 'productData' => $row));

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>
