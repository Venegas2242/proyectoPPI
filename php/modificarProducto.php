<?php
session_start();
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);
if ($isLoggedIn){
    $usuario = $_SESSION["user"];
    $id = $_SESSION["id"];
}


// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo json_encode(['error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()]);
    exit;
}

// Obtener el ID_Producto seleccionado (si está presente)
$idSeleccionado = isset($_POST['id_producto']) ? $_POST['id_producto'] : '';

// Consultar todos los productos
$query = "SELECT ID_Producto, Nombre FROM productos";
$result = mysqli_query($con, $query);

// Consultar los detalles del producto seleccionado (si hay uno seleccionado)
$productoSeleccionado = [];
$imagenes = [];
if (!empty($idSeleccionado)) {
    $queryDetalle = "SELECT * FROM productos WHERE ID_Producto = $idSeleccionado";
    $resultDetalle = mysqli_query($con, $queryDetalle);
    $productoSeleccionado = mysqli_fetch_assoc($resultDetalle);

    $queryFotos = "SELECT ID_Foto, Nombre_Foto FROM fotos WHERE ID_Producto = $idSeleccionado";
    $resultFoto = mysqli_query($con, $queryFotos);

    while ($row = mysqli_fetch_assoc($resultFoto)) {
        $imagenes[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Producto</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Your custom styles -->
    <link rel="stylesheet" href="/pruebas/estilos/barraNavegacion.css">
    <link rel="stylesheet" href="/pruebas/estilos/galeria.css">
    <link rel="stylesheet" href="/pruebas/estilos/carouselModa.css">
    <link rel="stylesheet" href="/pruebas/estilos/carritoCompras.css">
    <link rel="stylesheet" href="/pruebas/estilos/modificaciones.css">
    
</head>
<body>
    <!-- Incluir el archivo de la barra de navegación -->
    <?php include 'navigation-bar.php'; ?>
    
    <div class="container" id="modificaciones">
        <form class="form-inline" action="" method="post">
            <div class="form-group">
                <label for="productos">Seleccione un producto:</label>
                <select class="form-control" id="productos" name="id_producto">
                    <?php
                    // Mostrar opciones de productos
                    while ($row = mysqli_fetch_assoc($result)) {
                        $idProducto = $row['ID_Producto'];
                        $nombreProducto = $row['Nombre'];
                        $selected = ($idSeleccionado == $idProducto) ? 'selected' : '';
                        echo "<option value='$idProducto' $selected>$nombreProducto</option>";
                    }
                    ?>
                </select>
            </div>
        </form>

        <?php
        // Mostrar detalles del producto seleccionado
        if (!empty($productoSeleccionado)) {
            echo "<h2>Detalles del Producto Seleccionado</h2>";
            echo "<form action='/pruebas/php/actualizarProducto.php' method='post'>";
            echo "<input type='hidden' name='id_producto' value='{$productoSeleccionado['ID_Producto']}'>";
            echo "<div class='form-group'>";
            echo "<label for='nombre'>Nombre:</label>";
            echo "<input type='text' class='form-control' name='nombre' value='{$productoSeleccionado['Nombre']}'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='descripcion'>Descripción:</label>";
            echo "<textarea class='form-control' name='descripcion'>{$productoSeleccionado['Descripcion']}</textarea>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='precio'>Precio:</label>";
            echo "<input type='text' class='form-control' name='precio' value='{$productoSeleccionado['Precio']}'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='cantidad'>Cantidad en Almacén:</label>";
            echo "<input type='text' class='form-control' name='cantidad' value='{$productoSeleccionado['Cantidad_Almacen']}'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='fabricante'>Fabricante:</label>";
            echo "<input type='text' class='form-control' name='fabricante' value='{$productoSeleccionado['Fabricante']}'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='origen'>Origen:</label>";
            echo "<input type='text' class='form-control' name='origen' value='{$productoSeleccionado['Origen']}'>";
            echo "</div>";
            echo "<button type='submit' id='buttons' class='btn btn-primary'>Actualizar Producto</button>";
            echo "</form>";

            // Mostrar las imágenes asociadas al producto
            if (!empty($imagenes)) {
                echo "<h2>Imágenes del Producto</h2>";
                echo "<div class='image-container'>";
                foreach ($imagenes as $imagen) {
                    $idFoto = $imagen['ID_Foto'];
                    $nombreFoto = $imagen['Nombre_Foto'];
                    echo "<div class='image-item'>";
                    echo "<div class='image-content'>";
                    echo "<img src='/pruebas/imagenes/$nombreFoto' alt='Imagen $idFoto'>";
                    echo "<span class='delete-button' onclick='deleteImage($idFoto)'>Eliminar</span>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            }

            // Formulario para subir nuevas imágenes
            echo "<h2>Subir Nuevas Imágenes</h2>";
            echo "<form action='/pruebas/php/subirImagen.php' method='post' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='id_producto' value='{$productoSeleccionado['ID_Producto']}'>";
            echo '<div class="form-group">';
            echo '<input type="file" class="form-control" name="archivo[]" accept="image/*" multiple>';
            echo '</div>';
            echo "<button type='submit' id='buttons' class='btn btn-primary'>Subir Imagen</button>";
            echo "</form>";
        }
        ?>
    </div>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Función JavaScript para recargar la página al cambiar la selección
        document.getElementById('productos').addEventListener('change', function() {
            this.form.submit();
        });

        // Función para eliminar una imagen
        function deleteImage(idFoto) {
            if (confirm('¿Seguro que deseas eliminar esta imagen?')) {
                // Enviar la solicitud de eliminación al servidor
                $.ajax({
                    url: '/pruebas/php/eliminarImagen.php',
                    type: 'post',
                    data: { id_foto: idFoto },
                    success: function(response) {
                        // Recargar la página después de eliminar la imagen
                        location.reload();
                    },
                    error: function(error) {
                        console.error('Error al eliminar la imagen:', error);
                    }
                });
            }
        }
    </script>
</body>
</html>
