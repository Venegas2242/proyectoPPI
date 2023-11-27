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
    // Obtener los datos del formulario
    $nombre = mysqli_real_escape_string($con, $_POST["nombre"]);
    $descripcion = mysqli_real_escape_string($con, $_POST["descripcion"]);
    $precio = mysqli_real_escape_string($con, $_POST["precio"]);
    $cantidad = mysqli_real_escape_string($con, $_POST["cantidad"]);
    $fabricante = mysqli_real_escape_string($con, $_POST["fabricante"]);
    $origen = mysqli_real_escape_string($con, $_POST["origen"]);

    $insertProducto = "INSERT INTO `productos`(`Nombre`, `Descripcion`, `Precio`, `Cantidad_Almacen`, `Fabricante`, `Origen`) 
                        VALUES ('$nombre','$descripcion','$precio','$cantidad','$fabricante','$origen')";

    // Ejecutar la consulta
    if (mysqli_query($con, $insertProducto)) {
        // Obtener el ID del último producto insertado
        $idProductoResult = mysqli_query($con, "SELECT MAX(id_producto) as max_id FROM productos");
        $idProductoRow = mysqli_fetch_assoc($idProductoResult);
        $idProducto = $idProductoRow['max_id'];

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
                    // Imprimir la ruta relativa del archivo
                    //$rutaRelativa = $carpetaImagenes . $nombreUnico;
                    //echo "Ruta de la imagen: $rutaRelativa<br>";
                    // Puedes mostrar el archivo también si lo deseas
                    //echo '<img src="' . $rutaRelativa . '" alt="Imagen">';
                    //echo "<br><br>";

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
        }

        // Imprimir otros datos
        echo "Nombre del producto: $nombre<br>";
        echo "Descripción: $descripcion<br>";
        echo "Precio: $precio<br>";
        echo "Cantidad en almacen: $cantidad<br>";
        echo "Fabricante: $fabricante<br>";
        echo "Origen: $origen<br>";
    } else {
        echo "Error al insertar el producto en la base de datos.";
    }
}
header('Location: ../index.php');
exit;
?>