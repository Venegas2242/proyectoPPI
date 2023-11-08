function generarTarjetasDesdeDatos(datos) {
    var tarjetasContainer = document.getElementById('tarjetasContainer');
    
    datos.forEach(function (tarjeta) {
        var card = document.createElement('div');
        card.className = 'card mb-4';

        var cardBody = document.createElement('div');
        cardBody.className = 'card-body';

        var cardTitle = document.createElement('h2');
        cardTitle.className = 'card-title';
        cardTitle.textContent = tarjeta.Nombre_Tarjeta;

        var cardText = document.createElement('p');
        cardText.className = 'card-text';
        cardText.textContent = "Número de tarjeta: " + tarjeta.Numero_Tarjeta;

        cardBody.appendChild(cardTitle);
        cardBody.appendChild(cardText);
        card.appendChild(cardBody);

        tarjetasContainer.appendChild(card);
    });
}

// Realizar una solicitud AJAX para obtener datos de tarjetas
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        var datos = JSON.parse(xhr.responseText);
        generarTarjetasDesdeDatos(datos);
    }
};
xhr.open('GET', 'buscarTarjetas.php', true);
xhr.send();