<?php
session_start(); // Inicia la sesión

$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_SESSION["id"];

$result = mysqli_query($con, "SELECT h.Fecha_Compra, p.nombre, p.descripcion, p.precio, p.precio*COUNT(h.ID_Producto) AS total, p.fabricante, COUNT(h.ID_Producto) AS Numero_De_Compras FROM historial_compras h JOIN productos p ON h.ID_Producto = p.ID_Producto GROUP BY h.Fecha_Compra, h.ID_Producto;");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
    <style>
        .historial-block {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Historial de Compras</h1>

    <?php
    // Itera sobre los resultados y muestra la información en bloques
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="historial-block">';
        echo '<p>Fecha de Compra: ' . $row['Fecha_Compra'] . '</p>';
        echo '<p>Producto: ' . $row['nombre'] . '</p>';
        echo '<p>Descripción: ' . $row['descripcion'] . '</p>';
        echo '<p>Precio Unitario: ' . $row['precio'] . '</p>';
        echo '<p>Total: ' . $row['total'] . '</p>';
        echo '<p>Fabricante: ' . $row['fabricante'] . '</p>';
        echo '<p>Número de Compras: ' . $row['Numero_De_Compras'] . '</p>';
        echo '</div>';
    }
    ?>

</body>
</html>
