<?php
    session_start();

    // Verificar si el usuario está autenticado
    $isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);
    $usuario = $isLoggedIn ? $_SESSION['user'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Título de Página</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../estilos/barraNavegacion.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <?php include('navigation-bar.php'); ?>

    <div class="container" id="tarjetasContainer">
            <!-- Se insertan tarjetas con consultarMetodos.js -->
    </div>

    <div class=" container text-right mt-4">
        <a href="../html/insertDireccion.html" class="btn btn-primary">Registrar nueva dirección</a>
    </div>

    <script src="../js/consultarDirecciones.js">    </script>
</body>

</html>