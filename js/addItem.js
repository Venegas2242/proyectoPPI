const cartItems = [];

function addToCartList(cantidad, productName, productPrice, productImage, productQuantity) {
    console.log(`Producto agregado: Cantidad: ${cantidad}, Nombre: ${productName}, Precio: ${productPrice}, Cantidad: ${productQuantity}`);

    // Verifica si el producto ya está en el carrito
    const existingProduct = cartItems.find(item => item.cantidad === cantidad);

    if (existingProduct) {
        // Si el producto ya está en el carrito, puedes decidir qué acción tomar, por ejemplo, aumentar la cantidad
        // En este ejemplo, solo se incrementa la cantidad
        existingProduct.quantity += productQuantity;
    } else {
        // Si el producto no está en el carrito, agrégalo
        cartItems.push({ cantidad: cantidad, name: productName, price: productPrice, quantity: productQuantity, image: productImage });
    }

    updateCartCount();
    updateCartDisplay();
}

// Actualiza el número de elementos en el carrito
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
    cartList.innerHTML = ''; // Limpiar la lista antes de actualizarla

    cartItems.forEach(item => {
        const li = document.createElement("li");
        li.innerHTML = `
            <div class="cart-item">
                <div class="cart-item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="cart-item-details">
                    <strong> Cantidad: </strong> ${item.cantidad}<br>
                    <strong> Producto: </strong> ${item.name}<br>
                    <strong> Precio: </strong>  ${item.price}<br>
                    <strong> Cantidad: </strong> ${item.quantity}
                </div>
            </div>`;
        li.classList.add("cart-item"); // Agrega una clase al elemento li
        cartList.appendChild(li);
    });
}
