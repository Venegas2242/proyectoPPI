<?php
    $con=mysqli_connect("127.0.0.1","root","root","tiendaproyecto");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // escape variables for security
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $correo = mysqli_real_escape_string($con, $_POST['email']);
    $contraseña = mysqli_real_escape_string($con, $_POST['password']);
    $fecha = mysqli_real_escape_string($con, $_POST['date']);

    $sql="INSERT INTO Usuarios (Nombre_Usuario, Correo_Electronico, Contraseña, Fecha_Nacimiento)
      VALUES ('$nombre', '$correo', '$contraseña', '$fecha');";

    if (!mysqli_query($con,$sql)) {
      die('Error: ' . mysqli_error($con));
    }

    header('Location: ../index.php');
    exit;
  ?>