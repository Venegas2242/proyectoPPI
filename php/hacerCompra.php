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

// Variables para almacenar los IDs de productos sin suficiente cantidad
$productosSinCantidad = [];

// Realizar la consulta para obtener los datos de los productos y del carrito
$query = "SELECT ID_Producto FROM carrito_compras WHERE ID_USUARIO = $id;";
$result = mysqli_query($con, $query);

// Verificar si se obtuvieron resultados
if (!$result) {
    echo json_encode(['error' => 'No se pudieron obtener los datos de los productos.']);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    // Insertar en historial_compras
    $idProducto = $row['ID_Producto'];

    // Obtener la cantidad de productos
    $cantidadQuery = "SELECT Nombre, Cantidad_Almacen FROM productos WHERE ID_Producto = $idProducto";
    $cantidadResult = mysqli_query($con, $cantidadQuery);

    if (!$cantidadResult) {
        echo json_encode(['error' => 'Error al obtener la cantidad de productos: ' . mysqli_error($con)]);
        exit;
    }

    $cantidadRow = mysqli_fetch_assoc($cantidadResult);
    $cantidad = $cantidadRow['Cantidad_Almacen'];
    $producto = $cantidadRow['Nombre'];

    // Comparar la cantidad y realizar las acciones correspondientes
    if ($cantidad > 0) {
        // Insertar en historial_compras
        $queryInsert = "INSERT INTO historial_compras (ID_Producto, ID_Usuario, Fecha_Compra) VALUES ($idProducto, $id, '$fecha_actual')";
        mysqli_query($con, $queryInsert);

        // Actualizar la cantidad de productos en el inventario
        $queryUpdate = "UPDATE productos SET Cantidad_Almacen = Cantidad_Almacen - 1 WHERE ID_Producto = $idProducto";
        mysqli_query($con, $queryUpdate);
    } else {
        // Almacenar el ID del producto sin suficiente cantidad
        $productosSinCantidad[] = $producto;
    }
}

// Eliminar productos del carrito
$del = "DELETE FROM carrito_compras WHERE id_usuario = $id";
$result = mysqli_query($con, $del);

// Cerrar la conexión a la base de datos
mysqli_close($con);

// Mostrar pantalla intermedia
echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
echo '<title>Compra exitosa</title>';
// Agregar enlaces a los estilos de Bootstrap
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
// Agregar enlace a tu archivo CSS personalizado
echo '<link rel="stylesheet" href="styles.css">';
echo '</head>';
echo '<body>';
echo '<div class="container mt-5">';
echo '<div class="card p-4 text-center">';
echo '<h1 class="text-success mb-4">¡Compra exitosa!</h1>';

if (!empty($productosSinCantidad)) {
    echo '<div class="alert alert-danger">';
    echo '<p class="mb-2">Los siguientes productos no pudieron ser comprados porque no hay suficiente cantidad en el almacén:</p>';
    echo '<ul class="list-unstyled">';
    foreach ($productosSinCantidad as $producto) {
        echo "<li>Producto ID: $producto</li>";
    }
    echo '</ul>';
    echo '</div>';
}

// Agregar botón para regresar a index con estilo de Bootstrap
echo '<a href="/pruebas/index.php" class="btn btn-primary">Volver a la página principal</a>';
echo '</div>';
echo '</div>';
// Agregar scripts de Bootstrap
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>';
echo '</body>';
echo '</html>';
exit;
?>