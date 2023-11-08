<?php
    session_start();
    $con=mysqli_connect("127.0.0.1","root","root","tiendaproyecto");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // escape variables for security
    $noDireccion = mysqli_real_escape_string($con, $_POST['nombre_direccion']);
    $calle = mysqli_real_escape_string($con, $_POST['calle']);
    $numExterior = mysqli_real_escape_string($con, $_POST['numero_exterior']);
    $cPostal = mysqli_real_escape_string($con, $_POST['codigo_postal']);
    $estado = mysqli_real_escape_string($con, $_POST['estado']);
    $ciudad = mysqli_real_escape_string($con, $_POST['ciudad']);
    $id = $_SESSION['id'];

    $sql="INSERT INTO Direcciones (ID_Usuario, Nombre_Direccion, Calle, Numero_Exterior, Codigo_Postal, Estado, Ciudad)
      VALUES ('$id', '$noDireccion', '$calle', '$numExterior', '$cPostal', '$estado', '$ciudad');";


    if (!mysqli_query($con,$sql)) {
      die('Error: ' . mysqli_error($con));
    }

    header('Location: direcciones.php');
    exit;
  ?>