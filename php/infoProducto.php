<?php
$query = "SELECT p.nombre, p.descripcion, f.nombre_foto, p.precio, p.fabricante, p.origen FROM productos p join fotos f on f.ID_Producto = p.ID_Producto where p.ID_Producto = $productId";
$result3 = mysqli_query($con, $query);

if (!$result3) {
    echo json_encode(array('success' => false, 'message' => 'Failed to get product data.'));
    exit;
}
?>

<div class="modal fade" id="productModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel"><b>Detalles del Producto</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $numRows = mysqli_num_rows($result3); ?>
                    <!-- Carrusel Bootstrap -->
                    <div id="productCarousel<?php echo $i; ?>" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            for ($j = 0; $j < $numRows; $j++) {
                                $row = mysqli_fetch_assoc($result3);
                                $nombre = $row["nombre"];
                                $descripcion = $row["descripcion"];
                                $foto = $row["nombre_foto"];
                                $precio = $row["precio"];
                                $fabricante = $row["fabricante"];
                                $origen = $row["origen"];
                            ?>
                                <div class="carousel-item <?php echo $j == 0 ? 'active' : ''; ?>">
                                    <img src="/pruebas/imagenes/<?php echo $foto; ?>" alt="<?php echo $nombre; ?>" class="d-block w-100">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#productCarousel<?php echo $i; ?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#productCarousel<?php echo $i; ?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <!-- Información del producto -->
                    <div class="concert-info">
                        <h1><?php echo $nombre; ?></h1>
                        <p><strong>Descripción:</strong> <?php echo $descripcion; ?></p>
                        <p><strong>Precio:</strong> $<?php echo $precio; ?></p>
                        <p><strong>Fabricante:</strong> <?php echo $fabricante; ?></p>
                        <p><strong>Origen:</strong> <?php echo $origen; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>