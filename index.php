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

// Realizar una consulta para obtener los datos de los productos y del carrito
$query = "
    SELECT P.ID_Producto, P.Nombre, P.Precio,
           (SELECT Nombre_foto FROM fotos WHERE ID_Producto = P.ID_Producto LIMIT 1) as foto,
           COALESCE(COUNT(c.ID_Producto), 0) as cantidad,
           COALESCE(SUM(p.Precio), 0) as totalPrecio
    FROM productos P
    LEFT JOIN carrito_compras c ON c.id_usuario = 1 AND c.id_producto = P.ID_Producto
    GROUP BY P.ID_Producto
";
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="estilos/barraNavegacion.css">
    <link rel="stylesheet" href="estilos/galeria.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
    
</head>
<body>
    <!-- Incluir el archivo de la barra de navegación -->
    <?php include 'php/navigation-bar.php'; ?>

    <script src="js/addItem.js"></script>

    <div class="gallery">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $productId = $row["ID_Producto"];
            $productName = $row["Nombre"];
            $productPrice = $row["Precio"];
            $productImage = '/pruebas/imagenes/' . $row["foto"];
            $quantity = $row["cantidad"];
            $totalPrice = $row["totalPrecio"];

            ?>
        
            <div class="gallery-item">
                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
                <div class="product-details">
                    <div class="product-price">$<?php echo $productPrice; ?></div>
                    <div class="product-title"><?php echo $productName; ?></div>

                    <form id="addToCartForm_<?php echo $productId; ?>" action="php/addToCart.php" method="post">
                        <!-- Campos ocultos para almacenar información del producto -->
                        <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                        <input type="hidden" name="productName" value="<?php echo $productName; ?>">
                        <input type="hidden" name="productPrice" value="<?php echo $productPrice; ?>">
                        <input type="hidden" name="productImage" value="<?php echo $productImage; ?>">

                        <button type="button" class="add-to-cart-button" onclick="addToCart(<?php echo $productId; ?>, <?php echo $quantity; ?>, <?php echo $totalPrice; ?>); addToCartList(<?php echo $quantity; ?>, '<?php echo $productName; ?>', <?php echo $productPrice; ?>, '<?php echo $productImage; ?>', <?php echo $totalPrice; ?>)">+ Agregar</button>
                    </form>
                </div>
            </div>
        
            <?php
        }
        ?>
    </div>


    </div>


</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($con);
?>
