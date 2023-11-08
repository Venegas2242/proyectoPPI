<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Formulario de Tarjetas</title>
    <style>
        body {
            background-color: #84ff9f;
        }
    </style>
</head>

<body>
    <div class="container-fluid mx-auto w-75 mt-5">
        <div class="bg-white p-4 rounded shadow">
            <h1 class="text-center mb-4">Registrar Tarjeta</h1>
            <form action="registrarTarjeta.php" method="post">
                <div class="form-group">
                    <label for="numero_tarjeta">Número de Tarjeta:</label>
                    <input type="text" class="form-control" name="numero_tarjeta" required>
                </div>
                <div class="form-group">
                    <label for="nombre_tarjeta">Nombre en la Tarjeta:</label>
                    <input type="text" class="form-control" name="nombre_tarjeta" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="mes_expiracion">Mes de Expiración:</label>
                        <select class="form-control" name="mes_expiracion" required>
                            <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    $formattedMonth = ($i < 10) ? '0' . $i : $i;
                                    echo "<option value='$i'>$formattedMonth</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="año_expiracion">Año de Expiración:</label>
                        <select class="form-control" name="año_expiracion" required>
                            <?php
                                $currentYear = date("Y");
                                for ($i = $currentYear; $i <= $currentYear+20; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="number" class="form-control" name="cvv" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Guardar Tarjeta</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>