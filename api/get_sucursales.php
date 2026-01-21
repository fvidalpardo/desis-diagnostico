<?php
require_once '../config/db.php';
$stmt = $db->prepare("SELECT id, nombre FROM sucursales WHERE bodega_id = ?");
$stmt->execute([$_GET['bodega_id']]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));