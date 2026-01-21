<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <form id="productForm" class="product-form">
        <h2 class="title">Formulario de Producto</h2>

        <div class="form-container">
        
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" id="codigo">
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre">
            </div>
            <div class="form-group">
                <label for="bodega">Bodega</label>
                <select name="bodega" id="bodega">
                    <option value=""></option>
                    <?php
                    $stmt = $db->query("SELECT * FROM bodegas");
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sucursal">Sucursal</label>
                <select name="sucursal" id="sucursal" disabled>
                    <option value=""></option>
                </select>
            </div>
            <div class="form-group">
                <label for="moneda">Moneda</label>
                <select name="moneda" id="moneda">
                <option value=""></option>
                <?php
                $stmt = $db->query("SELECT * FROM           monedas");
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['simbolo']}</option>";
                    }
                ?>
            </select>
            </div>
    
            <div class="form-group">
    
                <label for="precio">Precio</label>
                <input type="text" name="precio" id="precio">
            </div>
    
            <div class="checkbox-group full-width">
                <label>Materiales del producto</label><br>
                <input type="checkbox" name="material[]" value="Plástico"> Plástico
                <input type="checkbox" name="material[]" value="Metal"> Metal
                <input type="checkbox" name="material[]" value="Madera"> Madera
                <input type="checkbox" name="material[]" value="Vidrio"> Vidrio
                <input type="checkbox" name="material[]" value="Textil"> Textil
            </div>
            <div class="form-group full-width">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="description-form"></textarea>
                </div>
        </div>

        
        <button type="submit" class="submit-btn">Guardar Producto</button>
    </form>

    <script src="assets/js/main.js"></script>
</body>
</html>