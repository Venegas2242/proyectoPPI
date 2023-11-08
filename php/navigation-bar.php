<nav class="navbar navbar-default navbar-expand">
    <div class="container">
        <!-- Contenido de la izquierda de la barra -->
        <ul class="nav navbar-nav">
            <li><a href="/pruebas/">
                <i class="fa fa-home"></i>
                Home
            </a></li>
            <li><a href="/pruebas/">Menu 1</a></li>
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
                </ul>
            </li>

            <li class="dropdown" id="login-dropdown">
                <?php if ($isLoggedIn) { ?>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i> <?php echo $usuario; ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
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
