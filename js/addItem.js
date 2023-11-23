// Arreglo que almacenará los elementos del carrito de compras
const cartItems = [];

// Función para agregar un producto al carrito y ejecutar una solicitud PHP
function addToCartListAndExecutePHP(productId) {
    // Realiza una solicitud AJAX para ejecutar addToCart.php
    fetch('/pruebas/php/addToCart.php', {
        method: 'POST',
        body: new URLSearchParams({
            'productId': productId
        }),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('addToCart.php executed successfully:', data.message);

            // Realiza una solicitud AJAX para obtener los nuevos datos del producto
            fetch('/pruebas/php/getProductData.php?productId=' + productId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Extrae los datos del producto
                        let { ID_Producto, Nombre, Precio, foto, cantidad, totalPrecio } = data.productData;

                        // Convierte cantidad a un número antes de la comparación
                        cantidad = parseInt(cantidad, 10);

                        // Llama a la función de JavaScript para agregar el producto al carrito
                        addToCartList((cantidad === 0) ? cantidad + 1 : cantidad, Nombre, Precio, "imagenes/" + foto, totalPrecio, ID_Producto);
                    } else {
                        console.error('Error during getProductData.php execution:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error during getProductData.php execution:', error);
                });

        } else {
            console.error('Error during addToCart.php execution:', data.message);
        }
    })
    .catch(error => {
        console.error('Error during addToCart.php execution:', error);
    });
}

// Función para obtener y actualizar los datos de un producto mediante una solicitud AJAX
function fetchAndRefreshProductData(productId, agregar) {
    // Asegúrate de definir o pasar las variables necesarias (productName, productPrice, etc.)
    if (parseInt(agregar) === 1) {
        console.log(`ENTRAMOS A 1`);
        // Llama a la función para agregar el producto al carrito con los nuevos datos
        addToCartListAndExecutePHP(productId);
    } else {
        console.log(`ENTRAMOS A 0`);
        // Realiza una solicitud AJAX para obtener los nuevos datos del producto
        fetch('/pruebas/php/getProductData.php?productId=' + productId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Extrae los datos del producto
                    let { ID_Producto, Nombre, Precio, foto, cantidad, totalPrecio } = data.productData;

                    // Llama a la función para agregar el producto al carrito con los nuevos datos
                    addToCartList(cantidad, Nombre, Precio, "imagenes/" + foto, totalPrecio, ID_Producto);
                } else {
                    console.error('Error during getProductData.php execution:', data.message);
                }
            })
            .catch(error => {
                console.error('Error during getProductData.php execution:', error);
            });
    }
}

// Función para agregar un producto al carrito de compras
function addToCartList(quantity, productName, productPrice, productImage, productQuantity, productId) {
    console.log(`Producto agregado: Cantidad: ${quantity}, Nombre: ${productName}, Precio: ${productPrice}, Cantidad: ${productQuantity}, Ruta: ${productImage}`);

    // Verifica si el producto ya está en el carrito
    const existingProduct = cartItems.find(item => item.productId === productId);

    if (existingProduct) {
        // Si el producto ya está en el carrito, actualiza la cantidad con la cantidad de la base de datos
        existingProduct.quantity = quantity;
    } else {
        // Si el producto no está en el carrito, agrégalo con la cantidad de la base de datos
        cartItems.push({ productId: productId, name: productName, price: productPrice, quantity: quantity, image: productImage, total: productQuantity });
    }

    // Actualiza el contador y la visualización del carrito
    updateCartCount();
    updateCartDisplay();
}

// Función para actualizar el número de elementos en el carrito
function updateCartCount() {
    const cartItemCount = document.getElementById("cart-item-count");
    cartItemCount.innerText = cartItems.length;

    // Actualiza el número en el icono del carrito
    const cartIcon = document.getElementById("cart-icon");
    cartIcon.querySelector('.badge').innerText = cartItems.length;
}

// Función para actualizar la visualización del carrito
function updateCartDisplay() {
    const cartList = document.getElementById("cart-items");
    cartList.innerHTML = ''; // Limpia la lista antes de actualizarla

    cartItems.forEach(item => {
        // Crea un nuevo elemento li para cada producto en el carrito
        const li = document.createElement("li");
        li.innerHTML = `
            <div class="cart-item">
                <div class="cart-item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="cart-item-details">
                    <strong> Cantidad: </strong> ${item.quantity}<br>
                    <strong> Producto: </strong> ${item.name}<br>
                    <strong> Precio Unitario: </strong>  ${item.price}<br>
                    <strong> Precio: </strong>  ${item.total}<br>
                </div>
            </div>`;
        li.classList.add("cart-item"); // Agrega una clase al elemento li
        cartList.appendChild(li); // Agrega el elemento li a la lista
    });
}
