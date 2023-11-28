<?php
session_start();

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit;
}

// Obtener el ID del producto desde el cuerpo de la solicitud POST
$productId = $_POST['productId'];
$idUsuario = $_SESSION["id"];

// Consulta SQL para obtener la cantidad en el carrito
$sql = "SELECT COALESCE(COUNT(c.ID_Producto), 0) as cantidad 
        FROM productos P 
        LEFT JOIN carrito_compras c ON c.id_usuario = $idUsuario AND c.id_producto = P.ID_Producto 
        WHERE P.ID_Producto = $productId 
        GROUP BY P.ID_Producto";

$result = $con->query($sql);

if ($result === FALSE) {
    die(json_encode(array('success' => false, 'message' => 'Error en la consulta: ' . $con->error)));
}

// Obtener el resultado de la consulta
$row = $result->fetch_assoc();

// Crear un arreglo asociativo para la respuesta JSON
$response = array('success' => true, 'cartQuantity' => $row['cantidad']);

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

// Cerrar la conexión
$con->close();
?>
    