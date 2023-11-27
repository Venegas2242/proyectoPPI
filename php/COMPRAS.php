<?php
session_start(); // Inicia la sesión

$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_SESSION["id"];

$query = "SELECT Fecha_Compra, SUM(p.precio) AS Total_Por_Fecha FROM historial_compras h JOIN productos p ON h.ID_Producto = p.ID_Producto WHERE ID_Usuario = $id GROUP BY Fecha_Compra;";
$result = mysqli_query($con, $query);
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
    $numCompra = 1;
    // Itera sobre los resultados y muestra la información en bloques
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="historial-block">';
        echo '<p>No. compra: ' . $numCompra;
        echo '<p>Fecha de Compra: ' . $row['Fecha_Compra'] . '</p>';
        echo '<p>Total: ' . $row['Total_Por_Fecha'] . '</p>';
        echo '</div>';
        $numCompra++;
    }
    ?>

</body>
</html>
