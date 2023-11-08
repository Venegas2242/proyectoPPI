<?php
session_start();
// Verificar si el usuario está autenticado
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);
$usuario = $isLoggedIn ? $_SESSION['user'] : '';

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

// Realizar una consulta para obtener los datos de los productos
$query = "SELECT P.ID_Producto, P.Nombre, P.Precio, (select Nombre_foto from fotos where ID_Producto = P.ID_Producto Limit 1) as foto FROM productos P; ";
$result = mysqli_query($con, $query);

// Verificar si se obtuvieron resultados
if (!$result) {
    echo "No se pudieron obtener los datos de los productos.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Título de Página</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="estilos/barraNavegacion.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /* Estilos para la galería */
        body {
            background-color: #f2f2f2;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .gallery-item img {
            width: auto; /* Tamaño fijo para las imágenes */
            height: 200px; /* Autoajustar la altura para mantener la proporción */
        }
        
        .cart-items li {
            width: 10px;
            height: 10px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .gallery-item {
            display: flex;
            flex-direction: column;
            align-items: center; /* Alineación horizontal al centro */
            justify-content: center; /* Alineación vertical al centro */
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            /*cursor: pointer;
            transition: transform 0.2s;*/
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .product-details {
            text-align: center;
            padding: 10px;
        }

        .product-title {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .product-price {
            color: #007bff;
            font-size: 1.2em;
        }

        .add-to-cart-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }


        .cart-item {
    display: flex;
    margin: 10px 0;
}

.cart-item-details {
    display: flex;
    flex-direction: column; /* Para alinear contenido verticalmente */
    align-items: center; /* Alineación horizontal al centro */
    justify-content: center; /* Alineación vertical al centro */
    text-align: justify; /* Alineación del texto en el centro */
}

.cart-item-image {
    width: 100px;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative; /* Importante para posicionar contenido dentro */
}

.cart-item-image img {
    max-width: 100%;
    max-height: 100%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
  
    </style>
    
</head>
<body>
    <!-- Incluir el archivo de la barra de navegación -->
    <?php include 'php/navigation-bar.php'; ?>

    <div class="gallery">
        <?php
        // Tu código de consulta y bucle PHP aquí
        while ($row = mysqli_fetch_assoc($result)) {
            $productId = $row["ID_Producto"];
            $productName = $row["Nombre"];
            $productPrice = $row["Precio"];
            $productImage = '/pruebas/imagenes/' . $row["foto"];
            ?>

            <div class="gallery-item">
                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
                <div class="product-details">
                    <div class="product-price">$<?php echo $productPrice; ?></div>
                    <div class="product-title"><?php echo $productName; ?></div>
                    <button class="add-to-cart-button" onclick='addToCart("<?php echo $productId; ?>", "<?php echo $productName; ?>", "<?php echo $productPrice; ?>", "<?php echo $productImage; ?>")'>+ Agregar</button>
                </div>
            </div>

            <?php
        }
        ?>
    </div>

    <script src="js/addItem.js"></script>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($con);
?>
