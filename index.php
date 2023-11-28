<?php
session_start();

// Verificar si el usuario está autenticado
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);
//$usuario = $isLoggedIn ? $_SESSION['user'] : '';

// Conectar a la base de datos
$con = mysqli_connect("127.0.0.1", "root", "root", "tiendaproyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

// Realizar una consulta para obtener los datos de los productos y del carrito
if ($isLoggedIn) {
    $usuario = $_SESSION["user"];
    $id = $_SESSION["id"];
    $query = "SELECT P.ID_Producto, P.Nombre, P.Precio, (SELECT Nombre_foto FROM fotos WHERE ID_Producto = P.ID_Producto LIMIT 1) as foto, COALESCE(COUNT(c.ID_Producto), 0) as cantidad, COALESCE(SUM(p.Precio), 0) as totalPrecio, Cantidad_Almacen FROM productos P LEFT JOIN carrito_compras c ON c.id_usuario = $id AND c.id_producto = P.ID_Producto GROUP BY P.ID_Producto;";
    $carrito = "SELECT P.ID_Producto, P.Cantidad_Almacen AS cantidadtotal, COALESCE(COUNT(c.ID_Producto), 0) as cantidad
    FROM productos P
    LEFT JOIN carrito_compras c ON c.id_producto = P.ID_Producto
    WHERE c.id_usuario = $id
    GROUP BY P.ID_Producto, P.Cantidad_Almacen
    HAVING cantidad > 0;
    ";
    $result = mysqli_query($con, $query);
    $result2 = mysqli_query($con, $carrito);

    // Utiliza un bucle while para almacenar los resultados en un array
$productIds = array();
$cantidadA = array();

while ($row = mysqli_fetch_assoc($result2)) {
    $productId = $row['ID_Producto'];
    $productIds[] = $productId;

    $cantidadAA = $row['cantidadtotal'];
    $cantidadA[] = $cantidadAA;
}

// Ahora que tienes los datos, puedes usar un bucle foreach para imprimir los scripts



    // Cerrar la conexión a la base de datos
    mysqli_close($con);
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="/pruebas/estilos/barraNavegacion.css">
    <link rel="stylesheet" href="/pruebas/estilos/galeria.css">

    
</head>
<body>
    <!-- Incluir el archivo de la barra de navegación -->
    <?php include 'php/navigation-bar.php'; ?>

    <script src="js/addItem.js"></script>

    <?php
    // Imprime llamadas a fetchAndRefreshProductData para cada ID_Producto
    if ($isLoggedIn) {
        foreach ($productIds as $index => $productId) {
            $cantidadAlmacen = $cantidadA[$index];
            echo "<script>fetchAndRefreshProductData($productId, '0', $cantidadAlmacen);</script>";
        }
    }
    ?>
    <?php
    if ($isLoggedIn) {
    ?>
    <div class="gallery">
     <?php   
            //echo "Hola usuario $usuario con id $id";
            while ($row = mysqli_fetch_assoc($result)) {
                $productId = $row["ID_Producto"];
                $productName = $row["Nombre"];
                $productPrice = $row["Precio"];
                $productImage = '/pruebas/imagenes/' . $row["foto"];
                $quantity = $row["cantidad"];
                $totalPrice = $row["totalPrecio"];
                $almacen = $row["Cantidad_Almacen"];

                ?>
            
                <div class="gallery-item">
                    <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
                    <div class="product-details">
                        <div class="product-price">$<?php echo $productPrice; ?></div>
                        <div class="product-title"><?php echo $productName; ?></div>

                        <form id="addToCartForm_<?php echo $productId; ?>" action="addToCart.php" method="post">
                            <!-- Campos ocultos para almacenar información del producto -->
                            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                            <input type="hidden" name="productName" value="<?php echo $productName; ?>">
                            <input type="hidden" name="productPrice" value="<?php echo $productPrice; ?>">
                            <input type="hidden" name="productImage" value="<?php echo $productImage; ?>">
                            <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                            <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
                            <input type="hidden" name="almacen" value="<?php echo $almacen; ?>">
                            <button type="button" class="add-to-cart-button" <?php echo $almacen == 0 ? 'disabled' : ''; ?> onclick="fetchAndRefreshProductData(<?php echo $productId; ?>, 4, <?php echo $almacen; ?>)">
                                <?php echo $almacen <= 0 ? 'Sin existencias' : '+ Agregar'; ?>
                            </button>

                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
    </div>
    
        <?php
        } else {
        ?>
    <div class="login-message">
        <h1>Para poder comprar, inicia sesión</h1>
    </div>
        <?php
        }
        ?>

    </div>


</body>
</html>