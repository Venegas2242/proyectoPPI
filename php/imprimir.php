<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $fabricante = $_POST["fabricante"];
    $origen = $_POST["origen"];

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
                $rutaRelativa = $carpetaImagenes . $nombreUnico;
                echo "Ruta de la imagen: $rutaRelativa<br>";
                // Puedes mostrar el archivo también si lo deseas
                echo '<img src="' . $rutaRelativa . '" alt="Imagen">';
                echo "<br><br>";
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
}
?>
