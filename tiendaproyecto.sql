-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2023 a las 03:48:30
-- Versión del servidor: 8.0.33
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendaproyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compras`
--

CREATE TABLE `carrito_compras` (
  `ID_Producto_Carrito` int NOT NULL,
  `ID_Usuario` int DEFAULT NULL,
  `ID_Producto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `ID_Direccion` int NOT NULL,
  `ID_Usuario` int DEFAULT NULL,
  `Nombre_Direccion` varchar(255) DEFAULT NULL,
  `Calle` varchar(255) DEFAULT NULL,
  `Numero_Exterior` varchar(10) DEFAULT NULL,
  `Codigo_Postal` int DEFAULT NULL,
  `Estado` varchar(255) DEFAULT NULL,
  `Ciudad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`ID_Direccion`, `ID_Usuario`, `Nombre_Direccion`, `Calle`, `Numero_Exterior`, `Codigo_Postal`, `Estado`, `Ciudad`) VALUES
(1, 5, 'Casa 1', 'Del Lindero', '167', 36640, 'Guanajuato', 'Irapuato'),
(2, 5, 'Casa 2', '1', '1', 1, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `ID_Foto` int NOT NULL,
  `ID_Producto` int DEFAULT NULL,
  `Nombre_Foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`ID_Foto`, `ID_Producto`, `Nombre_Foto`) VALUES
(4, 1, 'LECHESC1.webp'),
(7, 3, 'mayonesa1.webp'),
(8, 3, 'mayonesa2.webp'),
(9, 3, 'mayonesa3.webp'),
(24, 8, '6563f4337ef87_azucar1.webp'),
(25, 8, '6563f4337f9e8_azucar2.webp'),
(26, 8, '6563f43380456_azucar3.webp'),
(27, 9, '6563f9524e83d_aceite1.webp'),
(30, 10, '6563fa81db863_bimbo1.webp'),
(31, 10, '6563fa81dc259_bimbo2.webp'),
(32, 10, '6563fa81dcb9a_bimbo3.webp'),
(33, 10, '6563fa81dd3dc_bimbo4.webp'),
(34, 11, '6563fad57a3fb_tortillinas1.webp'),
(35, 11, '6563fad57ae60_tortillinas2.webp'),
(38, 9, '65644aa71bf55_aceite2.webp'),
(39, 9, '65644aa71ca27_aceite3.webp'),
(40, 4, '65644bd35b8e6_sal1.webp'),
(41, 5, '65644c2a0c865_salsa1.webp'),
(42, 5, '65644c2a0d764_salsa2.webp'),
(43, 5, '65644c2a0e2d6_salsa3.webp'),
(44, 12, '6564e6244d520_aceite2.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compras`
--

CREATE TABLE `historial_compras` (
  `Fecha_Compra` datetime DEFAULT NULL,
  `ID_Usuario` int DEFAULT NULL,
  `ID_Producto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `historial_compras`
--

INSERT INTO `historial_compras` (`Fecha_Compra`, `ID_Usuario`, `ID_Producto`) VALUES
('2023-11-28 03:28:46', 4, 12),
('2023-11-28 03:28:56', 1, 11),
('2023-11-28 03:28:56', 1, 10),
('2023-11-28 03:34:19', 4, 1),
('2023-11-28 03:34:19', 4, 12),
('2023-11-28 03:34:19', 4, 12),
('2023-11-28 03:34:38', 1, 11),
('2023-11-28 03:34:38', 1, 10),
('2023-11-28 03:34:38', 1, 10),
('2023-11-28 03:35:00', 1, 8),
('2023-11-28 03:41:51', 4, 12),
('2023-11-28 03:41:51', 4, 5),
('2023-11-28 03:41:51', 4, 5),
('2023-11-28 03:41:57', 1, 11),
('2023-11-28 03:41:57', 1, 10),
('2023-11-28 03:41:57', 1, 9),
('2023-11-28 03:41:57', 1, 3),
('2023-11-28 03:41:57', 1, 3),
('2023-11-28 03:41:57', 1, 3),
('2023-11-28 03:44:55', 4, 1),
('2023-11-28 03:44:55', 4, 12),
('2023-11-28 03:44:55', 4, 12),
('2023-11-28 03:44:55', 4, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Producto` int NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Descripcion` text,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Cantidad_Almacen` int DEFAULT NULL,
  `Fabricante` varchar(255) DEFAULT NULL,
  `Origen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_Producto`, `Nombre`, `Descripcion`, `Precio`, `Cantidad_Almacen`, `Fabricante`, `Origen`) VALUES
(1, 'Leche Santa Clara', 'Leche Santa Clara entera 1 L', 29.50, 0, 'A', 'A'),
(3, 'Mayonesa McCormick con limón 390 g', '¡Póngale lo sabroso!\r\nLa favorita de todos gracias a su irresistible sabor, la Mayonesa McCormick es perfecta por su toque exacto de limón. Ponle lo sabroso y dale ese extra de sabor a tus desayunos, comidas y cenas.\r\n- Consistencia cremosa como ninguna otra.\r\n- El acompañante ideal para tus platillos.\r\nEncuéntrala en sus diferentes tamaños y presentaciones, una para cada ocasión.\r\nRecuerda que ya puedes realizar tus compras en la tienda en línea, en donde también encontrarás todo lo necesario para tu día a día o para surtir la despensa de tu hogar. Compra lo que necesites ya que con nuestro servicio de entregas a domicilio tus compras llegarán hasta la puerta de tu hogar.', 53.00, 35, 'b', 'b'),
(4, 'Sal La Fina refinada 750 gr', 'Uno de los condimentos y especias que no puede faltar en ningún hogar es la sal refinada, pues es un producto que nos ayuda a darles a nuestras comidas un sabor especial. Por eso te presentamos la sal yodada y fluorada de La Fina, perfecta para preparar comidas saladas, como unas papas a la francesa o para tenerla siempre como sal de mesa. Este producto cuenta con certificación Kosher y consumirla con moderación es saludable.\r\nHacer compras en línea nunca había sido tan sencillo, agrega a tu carrito lo que necesites, ya que, con nuestro servicio de entregas a domicilio, tus productos llegarán hasta la puerta de tu hogar. Contamos con distintas formas de pago para que elijas la que más te convenga.', 16.00, 16, 'b', 'b'),
(5, 'Salsa picante Maga 1 L', 'La salsa picante Maga es un artículo que te ayudará a darle a tus antojos un toque diferente, disponible en presentación de 1 litro\r\n- Se lleva perfecto con botanas o fruta\r\n- Producto mexicano\r\n- Envase con tapa pequeña que ayuda a dosificar su uso\r\nRecuerda que ya puedes realizar tus compras en la tienda en línea, en donde también encontrarás todo lo necesario para tu día a día o para surtir la despensa de tu hogar. Compra lo que necesites ya que con nuestro servicio de entregas a domicilio tus compras llegarán hasta la puerta de tu hogar.', 26.00, 0, 'b', 'b'),
(8, 'Azúcar morena Zulka 1 kg', 'Endulza tus postres, bebidas y dulces con un toque de Azúcar Morena Zulka 100% de caña, dale un sabor gourmet a tus preparaciones sabiendo que consumes un producto de calidad.', 55.00, 18, 'Zulka', 'Zulka Origen'),
(9, 'Aceite puro de soya Nutrioli 946 ml', 'Cocina saludable con Nutrioli, aceite que es ideal para su uso diario en tus creaciones culinarias.\r\n- Contiene omegas 3, 6 y 9\r\n- Vitamina E\r\n- Sin colesterol por su origen vegetal\r\nNavega en nuestra tienda en línea y disfruta de nuestro servicio a domicilio que tenemos para ti y recibe tu despensa directo en las puertas de tu hogar.', 47.00, 29, 'Nutrioli', 'Nutrioli Origen'),
(10, 'Pan blanco Bimbo grande 680 g', 'Prueba el rico Pan Blanco Bimbo Grande es ideal para preparar un sabroso desayuno, lunch o cena. Es perfecto para hacer deliciosos sándwiches para toda la familia en cualquier momento del día.\r\n-No tiene sellos de advertencia.\r\n-Sin jarabe de maíz de alta fructosa. Hazlo como quieras. Haz Sándwich.\r\n-Empaque biodegradable\r\n-El pan del osito\r\nRecuerda que ya puedes realizar compras de éste y otros productos en tu tienda en línea donde encontrarás lo necesario para tu día a día o para surtir tu despensa. Compra lo que necesites ya que, con nuestro servicio de entregas a domicilio, tus compras llegarán hasta la puerta de tu hogar.', 47.50, 46, 'Bimbo', 'Bimbo Origen'),
(11, 'Tortillas de harina Tía Rosa Tortillinas 561 g', 'La verdadera quesadilla siempre es con Tortillinas. Tus Tortillinas que siempre te acompañan, son ideales para preparar deliciosas quesadillas con lo que más te gusta y con tu toque personal. Con su rico sabor casero y receta más rica y suave harán de tus quesadillas una deliciosa experiencia de sabor.\r\nTortillinas Tía Rosa van con lo que tu quieras.\r\nLa mejor compañía para tus comidas es Tortillinas Tía Rosa\r\nHaz tu súper en tu Tienda en línea y recibe tu compra en la comodidad de tu hogar.', 39.50, 10, 'Tía Rosa', 'Tía Rosa Origen'),
(12, '1', '1', 1.00, 0, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

CREATE TABLE `tarjetas` (
  `ID_Tarjeta` int NOT NULL,
  `ID_Usuario` int DEFAULT NULL,
  `Numero_Tarjeta` varchar(16) DEFAULT NULL,
  `Nombre_Tarjeta` varchar(255) DEFAULT NULL,
  `Mes_Expiracion` int DEFAULT NULL,
  `Año_Expiracion` int DEFAULT NULL,
  `CVV` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tarjetas`
--

INSERT INTO `tarjetas` (`ID_Tarjeta`, `ID_Usuario`, `Numero_Tarjeta`, `Nombre_Tarjeta`, `Mes_Expiracion`, `Año_Expiracion`, `CVV`) VALUES
(1, 1, '1234123412341234', 'Diego Venegas Granados', 1, 2023, '123'),
(2, 1, '5678567856785678', 'Diego Venegas Granados', 1, 2023, '234'),
(3, 1, '7890789078907890', 'Diego Venegas Granados', 1, 2023, '789'),
(4, 2, '1234', '1234', 1, 2023, '123'),
(5, 3, '123', '123', 1, 2023, '123'),
(6, 4, '1', '1', 10, 2023, '111'),
(7, 2, '12', '12', 1, 2023, '12'),
(8, 5, '123', '123', 1, 2023, '123'),
(9, 7, '1', '1', 10, 2023, '111');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int NOT NULL,
  `Nombre_Usuario` varchar(255) DEFAULT NULL,
  `Correo_Electronico` varchar(255) DEFAULT NULL,
  `Contraseña` varchar(255) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Nombre_Usuario`, `Correo_Electronico`, `Contraseña`, `Fecha_Nacimiento`) VALUES
(1, 'Diego', 'diego.venegas@anahuac.mx', '1234', '2002-04-22'),
(2, 'Esmeralda', 'esme@hotmail.com', '1234', '2023-10-26'),
(3, 'Daniela', 'dani@gmail.com', '1234', '1111-11-11'),
(4, 'admin', 'admin', 'admin', '1111-11-11'),
(5, 'Lesly', 'les@hotmail.com', '1234', '2023-11-03'),
(6, 'Regina', 'regina@hotmail.com', '1234', '0001-01-01'),
(7, 'USUARIO', 'usuarui@hotmail.com', '1234', '2023-11-08'),
(8, 'Xavo', 'xavo@gmail.com', '1234', '1111-11-11'),
(9, 'Alejandro Weintraub', 'alex@hotmail.com', '1234', '1111-11-11'),
(10, 'Maria Flores Laines ', 'maryflolaines@hotmail.com', 'Canelopower14', '2001-01-14');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD PRIMARY KEY (`ID_Producto_Carrito`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`ID_Direccion`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`ID_Foto`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Producto`);

--
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD PRIMARY KEY (`ID_Tarjeta`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  MODIFY `ID_Producto_Carrito` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=767;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `ID_Direccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `ID_Foto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Producto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  MODIFY `ID_Tarjeta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD CONSTRAINT `carrito_compras_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`),
  ADD CONSTRAINT `carrito_compras_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`);

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`),
  ADD CONSTRAINT `historial_compras_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`);

--
-- Filtros para la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD CONSTRAINT `tarjetas_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
