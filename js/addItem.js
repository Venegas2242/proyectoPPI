// Arreglo que almacenará los elementos del carrito de compras
let cartItems = [];

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

// Función para eliminar un producto del carrito y ejecutar una solicitud PHP
function deleteItemFromCartListAndExecutePHP(productId) {
    // Realiza una solicitud AJAX para ejecutar deleteToCart.php
    fetch('/pruebas/php/deleteToCart.php', {
        method: 'POST',
        body: `productId=${productId}`,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from deleteToCart.php:', data);

        if (data.success) {
            console.log('deleteToCart.php executed successfully:', data.message);

            // Elimina el producto del carrito localmente
            // removeFromCart(productId);

        } else {
            console.error('Error during deleteToCart.php execution:', data.message);
        }
    })
    .catch(error => {
        console.error('Error during deleteToCart.php execution:', error);
    });
}

function deleteProductFromCartListAndExecutePHP(productId) {
    // Realiza una solicitud AJAX para ejecutar deleteToCart.php
    fetch('/pruebas/php/deleteProductToCart.php', {
        method: 'POST',
        body: `productId=${productId}`,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from deleteProductToCart.php:', data);

        if (data.success) {
            console.log('deleteProductToCart.php executed successfully:', data.message);

            // Elimina el producto del carrito localmente
            removeFromCart(productId);

        } else {
            console.error('Error during deleteToCart.php execution:', data.message);
        }
    })
    .catch(error => {
        console.error('Error during deleteToCart.php execution:', error);
    });
}

function emptyCart() {
    // Realiza una solicitud AJAX para ejecutar emptyCart.php
    fetch('/pruebas/php/emptyCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from emptyCart.php:', data);

        if (data.success) {
            console.log('emptyCart.php executed successfully:', data.message);

            // Elimina el producto del carrito localmente
            clearCart();

        } else {
            console.error('Error during emptyCart.php execution:', data.message);
        }
    })
    .catch(error => {
        console.error('Error during emptyCart.php execution:', error);
    });
}


// Función para obtener y actualizar los datos de un producto mediante una solicitud AJAX
function fetchAndRefreshProductData(productId, agregar) {
    if (parseInt(agregar) === 1) {
        console.log(`ENTRAMOS A 1`);
        // Llama a la función para agregar el producto al carrito con los nuevos datos
        addToCartListAndExecutePHP(productId);
    } else if (parseInt(agregar) === 2) {
        deleteItemFromCartListAndExecutePHP(productId);
    } else if (parseInt(agregar) === 3) {
        deleteProductFromCartListAndExecutePHP(productId);
    } else { // Este else es para cargar carrito al iniciar pagina
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
                    <strong> Cantidad: </strong> 
                    <button class="quantity-button" onclick="decreaseQuantity('${item.productId}'); fetchAndRefreshProductData('${item.productId}', '2');">-</button>
                    ${item.quantity}
                    <button class="quantity-button" onclick="increaseQuantity('${item.productId}'); fetchAndRefreshProductData('${item.productId}', '1');">+</button>
                    <button class="remove-button" onclick="removeFromCart('${item.productId}'); fetchAndRefreshProductData('${item.productId}', '3');">Eliminar</button><br>
                    <strong> Producto: </strong> ${item.name}<br>
                    <strong> Precio Unitario: </strong>  ${item.price}<br>
                    <strong> Precio: </strong>  ${item.total}<br>
                </div>
            </div>`;
        li.classList.add("cart-item"); // Agrega una clase al elemento li
        cartList.appendChild(li); // Agrega el elemento li a la lista
    });
}

// Función para disminuir la cantidad de un producto en el carrito
function decreaseQuantity(productId) {
    const product = cartItems.find(item => item.productId === productId);

    if (product && product.quantity > 1) {
        product.quantity--;

        // Realiza las actualizaciones necesarias después de disminuir la cantidad
        updateCartCount();
        updateCartDisplay();
    }
}

// Función para aumentar la cantidad de un producto en el carrito
function increaseQuantity(productId) {
    const product = cartItems.find(item => item.productId === productId);

    if (product) {
        product.quantity++;

        // Realiza las actualizaciones necesarias después de aumentar la cantidad
        updateCartCount();
        updateCartDisplay();
    }
}

// Función para eliminar un producto del carrito
function removeFromCart(productId) {
    const index = cartItems.findIndex(item => item.productId === productId);

    if (index !== -1) {
        cartItems.splice(index, 1);

        // Realiza las actualizaciones necesarias después de eliminar el producto
        updateCartCount();
        updateCartDisplay();
    }
}

// Función para eliminar todos los productos del carrito
function clearCart() {
    const productIds = cartItems.map(item => item.productId);

    productIds.forEach(currentProductId => {
        const index = cartItems.findIndex(item => item.productId === currentProductId);

        if (index !== -1) {
            cartItems.splice(index, 1);
        }
    });

    // Realiza las actualizaciones necesarias después de eliminar todos los productos
    updateCartCount();
    updateCartDisplay();
}
