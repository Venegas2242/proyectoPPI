function generarTarjetasDesdeDatos(datos) {
    var tarjetasContainer = document.getElementById('tarjetasContainer');

    datos.forEach(function (direccion) {
        var card = document.createElement('div');
        card.className = 'card mb-4';

        var cardBody = document.createElement('div');
        cardBody.className = 'card-body';

        var cardTitle = document.createElement('h2');
        cardTitle.className = 'card-title';
        cardTitle.textContent = direccion.Nombre_Direccion;

        var cardText = document.createElement('p');
        cardText.className = 'card-text';
        cardText.innerHTML = "<strong>Calle:</strong> " + direccion.Calle;

        // Agregar más datos a la tarjeta con texto en negritas sin espacios adicionales
        var additionalData = document.createElement('p');
        additionalData.className = 'card-text';
        additionalData.innerHTML = "<strong>Número Exterior:</strong>" + direccion.Numero_Exterior;
        cardText.appendChild(additionalData);

        additionalData = document.createElement('p');
        additionalData.className = 'card-text';
        additionalData.innerHTML = "<strong>Código Postal:</strong>" + direccion.Codigo_Postal;
        cardText.appendChild(additionalData);

        additionalData = document.createElement('p');
        additionalData.className = 'card-text';
        additionalData.innerHTML = "<strong>Estado:</strong>" + direccion.Estado;
        cardText.appendChild(additionalData);

        additionalData = document.createElement('p');
        additionalData.className = 'card-text';
        additionalData.innerHTML = "<strong>Ciudad:</strong>" + direccion.Ciudad;
        cardText.appendChild(additionalData);

        cardBody.appendChild(cardTitle);
        cardBody.appendChild(cardText);
        card.appendChild(cardBody);

        tarjetasContainer.appendChild(card);
    });
}

// Realizar una solicitud AJAX para obtener datos de direcciones
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        var datos = JSON.parse(xhr.responseText);
        generarTarjetasDesdeDatos(datos);
    }
};
xhr.open('GET', 'buscarDirecciones.php', true);
xhr.send();
