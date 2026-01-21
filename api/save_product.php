<?php
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../config/db.php';

    $codigo      = $_POST['codigo'] ?? '';
    $nombre      = $_POST['nombre'] ?? '';
    $bodega_id   = (int)($_POST['bodega'] ?? 0);
    $sucursal_id = (int)($_POST['sucursal'] ?? 0);
    $moneda_id   = (int)($_POST['moneda'] ?? 0);
    $precio      = (float)($_POST['precio'] ?? 0);
    $descripcion = $_POST['descripcion'] ?? '';
    $materiales  = $_POST['material'] ?? [];

    // Formatear materiales para el array de PostgreSQL 
    $materialesPostgres = '{' . implode(',', $materiales) . '}';

    $sql = "INSERT INTO productos (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, materiales, descripcion) 
            VALUES (:codigo, :nombre, :bodega, :sucursal, :moneda, :precio, :materiales, :descripcion)";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':codigo'      => $codigo,
        ':nombre'      => $nombre,
        ':bodega'      => $bodega_id,
        ':sucursal'    => $sucursal_id,
        ':moneda'      => $moneda_id,
        ':precio'      => $precio,
        ':materiales'  => $materialesPostgres,
        ':descripcion' => $descripcion
    ]);

    echo json_encode(['success' => true, 'message' => '¡Producto guardado exitosamente en la base de datos!']);

} catch (PDOException $e) {
    // Si ya existe el codigo, se tira error de duplicidad
    if ($e->getCode() == '23505') {
        echo json_encode(['success' => false, 'message' => 'El código del producto ya está registrado.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error general: ' . $e->getMessage()]);
}