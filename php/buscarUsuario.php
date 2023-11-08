<?php
session_start(); // Inicia la sesión

$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$nombre = mysqli_real_escape_string($con, $_POST['username']);
$contraseña = mysqli_real_escape_string($con, $_POST['password']);

$result = mysqli_query($con, "SELECT * FROM usuarios WHERE Nombre_Usuario='$nombre' AND Contraseña='$contraseña';");

$response = array();

if ($row = mysqli_fetch_array($result)) {
    $_SESSION['id'] = $row['ID_Usuario'];
    $_SESSION['user'] = $row['Nombre_Usuario'];
}

header("Location: ../index.php");

exit;
?>