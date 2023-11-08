<?php
session_start(); // Inicia la sesión

$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_SESSION["id"];

$result = mysqli_query($con, "SELECT * FROM Direcciones WHERE ID_Usuario='$id';");

$response = array();

while ($row = mysqli_fetch_assoc($result)) {
  $response[] = $row;
}

mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($response);
?>