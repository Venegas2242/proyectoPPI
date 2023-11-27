<?php
session_start();

// Verificar si el usuario está autenticado
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);
//$usuario = $isLoggedIn ? $_SESSION['user'] : '';
$usuario = $_SESSION["user"];

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

$id = $_SESSION["id"];

$query = "SELECT Fecha_Compra, SUM(p.precio) AS Total_Por_Fecha FROM historial_compras h JOIN productos p ON h.ID_Producto = p.ID_Producto WHERE ID_Usuario = $id GROUP BY Fecha_Compra;";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="/pruebas/estilos/barraNavegacion.css">
    <style>
        /* Estilos para el historial de compras */
        body {
            background-color: #f2f2f2;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .historial-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px;
        }

        .historial-block {
            width: 100%;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .historial-block:hover {
            background-color: #f0f0f0;
        }

        .historial-block p {
            margin: 5px 0;
        }

        /* Estilo para el número de compra */
        .historial-block .numero-compra {
            font-weight: bold;
            font-size: 1.2em;
            color: #333; /* Color del texto */
        }

        /* Estilo para la fecha de compra */
        .historial-block .fecha-compra {
            font-size: 0.9em;
            color: #555;
        }

        /* Estilo para el total */
        .historial-block .total {
            font-size: 1.1em;
            color: #007bff; /* Color del texto */
        }

        /* Estilo para el botón */
        .historial-block button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'navigation-bar.php'; ?>

    <div class="historial-container">
        <?php
        $numCompra = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<form class="historial-form" action="infoCompra.php" method="post">';
            echo '<div class="historial-block">';
            echo '<input type="hidden" name="fecha_compra" value="' . $row['Fecha_Compra'] . '">';
            echo '<p class="numero-compra">No. compra: ' . $numCompra . '</p>';
            echo '<p class="fecha-compra">Fecha de Compra: ' . $row['Fecha_Compra'] . '</p>';
            echo '<p class="total">Total: $' . $row['Total_Por_Fecha'] . '</p>';
            echo '<button type="submit">Ver Detalles</button>';
            echo '</div>';
            echo '</form>';
            $numCompra++;
        }        
        ?>
    </div>

</body>
</html>
