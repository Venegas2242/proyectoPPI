<?php
session_start();

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo json_encode(['error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el ID del producto
    $idProducto = $_POST["id_producto"];

    // Manejar las imágenes
    if (isset($_FILES["archivo"])) {
        $archivos = $_FILES["archivo"];
        $numArchivos = count($archivos["name"]);

        // Carpeta general de imágenes
        $carpetaImagenes = "imagenes/";

        // Retroceder una carpeta desde el directorio actual
        $directorioDestino = realpath(dirname(__DIR__)) . "/$carpetaImagenes";

        if (!is_dir($directorioDestino)) {
            // Si el directorio no existe, intenta crearlo
            if (!mkdir($directorioDestino, 0777, true)) {
                echo "Error al crear el directorio de destino.";
                exit;
            }
        }

        for ($i = 0; $i < $numArchivos; $i++) {
            $nombreArchivo = $archivos["name"][$i];
            $rutaTempArchivo = $archivos["tmp_name"][$i];

            // Generar un nombre único para evitar conflictos de nombres
            $nombreUnico = uniqid() . "_" . $nombreArchivo;

            // Mover el archivo al directorio de destino con el nombre único
            $rutaDestino = $directorioDestino . "/" . $nombreUnico;
            if (move_uploaded_file($rutaTempArchivo, $rutaDestino)) {
                // Insertar la información de la imagen en la base de datos
                $insertImagen = "INSERT INTO `fotos`(`ID_Producto`, `Nombre_Foto`) VALUES ('$idProducto','$nombreUnico')";
                if (!mysqli_query($con, $insertImagen)) {
                    echo "Error al insertar la información de la imagen en la base de datos.";
                    exit;
                }
            } else {
                echo "Error al mover el archivo: " . $nombreArchivo . ". Error: " . $archivos["error"][$i];
            }
        }

        // Redirigir a la página principal o a donde sea necesario
        header("Location: modificarProducto.php");
        exit;
    }
}
?>