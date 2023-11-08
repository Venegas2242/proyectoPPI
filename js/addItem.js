const cartItems = [];

function addToCart(productId, productName, productPrice, productImage) {
    console.log(`Producto agregado: ID: ${productId}, Nombre: ${productName}, Precio: ${productPrice}`);

    // Verifica si el producto ya está en el carrito
    const existingProduct = cartItems.find(item => item.id === productId);

    if (existingProduct) {
        // Si el producto ya está en el carrito, puedes decidir qué acción tomar, por ejemplo, aumentar la cantidad
        // En este ejemplo, solo se incrementa la cantidad
        existingProduct.quantity += 1;
    } else {
        // Si el producto no está en el carrito, agrégalo
        cartItems.push({ id: productId, name: productName, price: productPrice, quantity: 1, image: productImage });
    }

    updateCartCount();
    updateCartDisplay(existingProduct.quantity);
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
function updateCartDisplay(existingProduct) {
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
                    <strong> ID: </strong> ${item.id}<br>
                    <strong> Producto: </strong> ${item.name}<br>
                    <strong> Precio: </strong>  ${item.price}
                    <strong> Cantidad: </strong> ${existingProduct}
                </div>
            </div>`;
        li.classList.add("cart-item"); // Agrega una clase al elemento li
        cartList.appendChild(li);
    });
}
