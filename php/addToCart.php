<?php
    session_start();
    $con=mysqli_connect("127.0.0.1","root","root","tiendaproyecto");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $id = $_SESSION["id"];

    // escape variables for security
    $productId = mysqli_real_escape_string($con, $_POST['productId']);

    $sql="INSERT INTO carrito_compras (ID_Usuario, ID_Producto)
      VALUES ('$id', '$productId');";

    if (!mysqli_query($con,$sql)) {
      die('Error: ' . mysqli_error($con));
    }

    header('Location: ../index.php');
    exit;
  ?>