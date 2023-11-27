<style>
:root {
    --primary-color: #007bff;
    --secondary-color: #337ab7;
    --text-color: #333;
    --background-color: #fff;
    --border-color: #e1e1e1;
    --shadow-color: rgba(0, 0, 0, 0.1);
    --danger-color: #d83d3d;
}

/* Estilos para el menú desplegable personalizado */
ul.dropdown-menu.custom-menu,
ul.dropdown-menu {
    min-width: 200px;
    width: 200px;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    box-shadow: 0 3px 5px var(--shadow-color);
    padding: 10px;
}

/* Estilos para los elementos del menú personalizado */
ul.dropdown-menu.custom-menu .dropdown-item,
ul.dropdown-menu .dropdown-item {
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: 16px;
}

/* Estilos para los enlaces del menú personalizado */
ul.dropdown-menu.custom-menu .dropdown-item a,
ul.dropdown-menu .dropdown-item a {
    display: block;
    padding: 8px 15px;
    text-decoration: none;
    color: var(--text-color);
    transition: background-color 0.3s;
}

/* Estilos al pasar el ratón por encima de los enlaces del menú personalizado */
ul.dropdown-menu.custom-menu .dropdown-item a:hover,
ul.dropdown-menu .dropdown-item a:hover {
    background-color: var(--secondary-color);
    color: #fff;
}

/* Estilos para la barra de navegación */
.navbar {
    background-color: var(--primary-color);
    margin-bottom: 20px;
}

/* Estilos para los elementos de la barra de navegación */
.navbar .nav > li > a {
    color: #fff;
}

/* Estilos al pasar el ratón por encima de los elementos de la barra de navegación */
.navbar .nav > li > a:hover {
    background-color: var(--secondary-color);
}

/* Mostrar el menú desplegable al pasar el ratón por encima del elemento de la barra de navegación */
.navbar .nav > li.dropdown:hover .dropdown-menu {
    display: block;
    width: 320px;
}

/* Estilos para el ícono del carrito de compras */
.cart-icon {
    position: relative;
    cursor: pointer;
    display: flex;
    align-items: center;
    color: #fff;
}

.cart-icon .fa-shopping-cart {
    font-size: 24px;
    margin-right: 5px;
}

/* Estilos para el contador del carrito de compras */
.cart-icon .badge {
    position: absolute;
    top: 0;
    right: 0;
    transform: translate(50%, -50%); /* Ajusta la posición a la esquina superior derecha */
    background-color: var(--danger-color);
    color: #fff;
    border: 1px solid red;
    font-size: 12px;
    border-radius: 50%;
    padding: 5px 8px;
}


/* Estilos para el contenedor del carrito de compras */
#cart-items {
    width: 350px;
    background-color: var(--background-color);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    box-shadow: 0 2px 5px var(--shadow-color);
    overflow-y: auto;

    scrollbar-width: thin; 
    scrollbar-color: var(--border-color) var(--background-color); 

    &::-webkit-scrollbar {
        width: 8px;
    }

    &::-webkit-scrollbar-thumb {
        background-color: var(--border-color);
        border-radius: 4px;
    }

    &::-webkit-scrollbar-track {
        background-color: var(--background-color);
        border-radius: 4px;
    }

    list-style-type: none;
    padding: 0;
}

/* Estilos de los elementos del carrito */
.cart-item {
    display: flex;
    padding: 10px;
    border-bottom: 1px solid var(--border-color);
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 15px;
}

.cart-item-image img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    margin-right: 10px;
}

.cart-item-details {
    flex: 1;
}

/* Estilos para el botón "Hola" dentro del menú desplegable */
#boton1 {
    background-color: var(--primary-color);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 70%; /* Ocupa el ancho completo del contenedor */
    display: block; /* Hace que el botón sea un bloque para centrar el texto */
    margin: 10px auto; /* Centra el botón dentro del contenedor verticalmente y horizontalmente */
}

#boton1:hover {
    background-color: var(--secondary-color);
}

</style>
<nav class="navbar navbar-default navbar-expand">
    <div class="container">
        <!-- Contenido de la izquierda de la barra -->
        <ul class="nav navbar-nav">
            <li><a href="/pruebas/">
                <i class="fa fa-home"></i>
                Home
            </a></li>
            <?php
            if ($isLoggedIn && $id == 1) {
                echo "<li><a href='/pruebas/html/nuevoProducto.html'>Agregar Producto</a></li>";
            }
            ?>
        </ul>

        <!-- Contenido a la derecha de la barra -->
        <ul class="nav navbar-nav navbar-right">
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
                        
                    </li>
                    <form action="/pruebas/php/hacerCompra.php">
                        <li><button id="boton1" >Comprar</button></li>
                    </form>
                    <button onclick="emptyCart();">Vacíar carrito</button>
                </ul>
            </li>

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
                            <a href="/pruebas/php/metodosPago.php">Métodos de pago</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="/pruebas/php/direcciones.php">Direcciones</a>
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
                                    <label for="username">Usuario:</label>
                                    <input type="text" class="form-control" name="username" placeholder="Ingresa tu usuario">
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