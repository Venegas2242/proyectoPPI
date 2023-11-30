<?php
// Realizar una consulta para obtener los datos de los productos y del carrito
if ($isLoggedIn) {
    $carrito = "SELECT P.ID_Producto, P.Cantidad_Almacen AS cantidadtotal, COALESCE(COUNT(c.ID_Producto), 0) as cantidad
    FROM productos P
    LEFT JOIN carrito_compras c ON c.id_producto = P.ID_Producto
    WHERE c.id_usuario = $id
    GROUP BY P.ID_Producto, P.Cantidad_Almacen
    HAVING cantidad > 0;
    ";
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
}
?>

<nav class="navbar navbar-default navbar-expand">
    <div class="container">
        <?php if ($isLoggedIn) { ?>
        <!-- Contenido de la izquierda de la barra -->
        <ul class="nav navbar-nav">
            <li><a href="/pruebas/">
                <i class="fa fa-home"></i>
                Home
            </a></li>
            <?php
            if ($id == 1) {
                echo "<li><a href='/pruebas/html/nuevoProducto.html'>Agregar Producto</a></li>";
                echo "<li><a href='/pruebas/php/modificarProducto.php'>Modificar Producto</a></li>";
            }
            ?>
        </ul>
        <?php } ?>
        <!-- Contenido a la derecha de la barra -->
        <ul class="nav navbar-nav navbar-right">
            <?php
            if ($isLoggedIn) {
            ?> 
            <!-- Carrito de compras -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <div class="cart-icon" id="cart-icon">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="badge" id="cart-item-count">0</span>
                    </div>
                </a>
                <ul class="dropdown-menu">
                    <li id="cart-items">
                        <!-- Contenido del carrito -->
                    </li>
                    <form action="/pruebas/php/hacerCompra.php">
                        <li id="comprar-button">
                            <button id="boton1">Comprar</button>
                        </li>
                    </form>
                    <li id="vaciar-carrito-button">
                        <button id="vaciar-carrito" onclick="emptyCart();">Vaciar carrito</button>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <li class="dropdown" id="login-dropdown">
                <?php if ($isLoggedIn) { ?>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i> <?php echo $usuario; ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item">
                            <a href="/pruebas/php/historialCompras.php">Pedidos Realizados</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="/pruebas/php/cerrarSesion.php">Cerrar sesión</a>
                        </li>
                    </ul>
                <?php } else { ?>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i> Iniciar sesión <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form action="/pruebas/php/buscarUsuario.php" method="post" id="login-form">
                                <div class="form-group">
                                    <label for="mail">Correo:</label>
                                    <input type="text" class="form-control" name="mail" placeholder="Ingresa tu usuario">
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña:</label>
                                    <input type="password" class="form-control" name="password" placeholder="Ingresa tu contraseña">
                                </div>
                                <div>
                                    <label for="noaccount">¿No tienes cuenta?<a href="/pruebas/html/crearCuenta.html"> Crea una aquí</a></label>
                                </div>
                                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                            </form>
                        </li>
                    </ul>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>

<script src="/pruebas/js/addItem.js"></script>

<?php
// Imprime llamadas a fetchAndRefreshProductData para cada ID_Producto
if ($isLoggedIn) {
    foreach ($productIds as $index => $productId) {
        $cantidadAlmacen = $cantidadA[$index];
        echo "<script>fetchAndRefreshProductData($productId, '0', $cantidadAlmacen);</script>";
    }
}
?>