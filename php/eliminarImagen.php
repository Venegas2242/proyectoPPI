<?php
// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario
    $idFoto = $_POST["id_foto"];

    // Obtener el nombre del archivo de la base de datos
    $query = "SELECT Nombre_Foto FROM fotos WHERE ID_Foto = $idFoto";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $nombreFoto = $row['Nombre_Foto'];

    // Ruta completa al archivo de imagen
    $rutaImagen = $_SERVER['DOCUMENT_ROOT'] . "/pruebas/imagenes/$nombreFoto";

    // Eliminar la entrada de la base de datos
    $delete = "DELETE FROM `fotos` WHERE ID_Foto = $idFoto";

    if (mysqli_query($con, $delete)) {
        // La consulta fue exitosa, ahora eliminar el archivo de imagen
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        // Redirigir a la página principal o a donde sea necesario
        header("Location: modificarProducto.php");
        exit;
    } else {
        // Error en la consulta
        echo "Error en la eliminación: " . mysqli_error($con);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>
