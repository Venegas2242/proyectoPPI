<?php
    session_start();
    $con=mysqli_connect("127.0.0.1","root","root","tiendaproyecto");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // escape variables for security
    $noTarjeta = mysqli_real_escape_string($con, $_POST['numero_tarjeta']);
    $nombreTarjeta = mysqli_real_escape_string($con, $_POST['nombre_tarjeta']);
    $mes = mysqli_real_escape_string($con, $_POST['mes_expiracion']);
    $año = mysqli_real_escape_string($con, $_POST['año_expiracion']);
    $cvv = mysqli_real_escape_string($con, $_POST['cvv']);
    $id = $_SESSION['id'];

    $sql="INSERT INTO Tarjetas (ID_Usuario, Numero_Tarjeta, Nombre_Tarjeta, Mes_Expiracion, Año_Expiracion, CVV)
      VALUES ('$id', '$noTarjeta', '$nombreTarjeta', '$mes', '$año', '$cvv');";


    if (!mysqli_query($con,$sql)) {
      die('Error: ' . mysqli_error($con));
    }

    header('Location: metodosPago.php');
    exit;
  ?>