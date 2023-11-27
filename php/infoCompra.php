<?php
session_start(); // Inicia la sesión

// Verificar si el usuario está autenticado
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);
$usuario = $_SESSION["user"];

$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_SESSION["id"];
$fechaCompra = $_POST['fecha_compra'];

$result = mysqli_query($con, "SELECT h.Fecha_Compra, p.nombre, p.descripcion, p.precio, COUNT(h.ID_Producto) AS Numero_De_Compras, SUM(p.precio) AS total, p.fabricante, ( SELECT Nombre_foto FROM fotos WHERE ID_Producto = p.ID_Producto LIMIT 1 ) AS foto FROM historial_compras h JOIN productos p ON h.ID_Producto = p.ID_Producto WHERE h.ID_Usuario = $id AND h.Fecha_Compra = '$fechaCompra' GROUP BY h.Fecha_Compra, p.ID_Producto;
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de compra</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="/pruebas/estilos/barraNavegacion.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        a.back-link {
            margin: 20px;
            text-decoration: none;
            color: #167cd6;
            font-size: 20px;
            display: inline-block;
        }

        .historial-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        .historial-block {
            display: flex;
            align-items: center;
            width: 100%;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 20px; /* Aumenta el espacio interno */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .historial-block img {
            max-width: 150px;
            height: auto;
            margin-right: 20px; /* Reduce el espacio a la derecha de la imagen */
        }

        .historial-block-info {
            flex-grow: 1;
        }

        .historial-block p {
            margin: 10px 0; /* Aumenta el espacio vertical entre párrafos */
            color: #333;
        }

        .historial-block strong {
            color: #007bff;
        }
    </style>
</head>
<body>
    <?php include 'navigation-bar.php'; ?>

    <a href="/pruebas/php/historialCompras.php" class="back-link">
        <i class="fa fa-arrow-left"></i> Regresar
    </a>

    <div class="historial-container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $productImage = '/pruebas/imagenes/' . $row["foto"];
            $productName = $row["nombre"];
            
            echo '<div class="historial-block">';
            echo '<img src=' . $productImage . ' alt="' . $productName . '">';
            echo '<div class="historial-block-info">';
            echo '<p><strong>Producto:</strong> ' . $row['nombre'] . '</p>';
            echo '<p><strong>Descripción:</strong> ' . $row['descripcion'] . '</p>';
            echo '<p><strong>Número de Compras:</strong> ' . $row['Numero_De_Compras'] . '</p>';
            echo '<p><strong>Precio Unitario:</strong> $' . $row['precio'] . '</p>';
            echo '<p><strong>Total:</strong> $' . $row['total'] . '</p>';
            echo '<p><strong>Fabricante:</strong> ' . $row['fabricante'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>