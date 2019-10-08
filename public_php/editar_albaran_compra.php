<?php
require_once __DIR__.'/../request.php';
require_once __DIR__.'/../db.php';

$dbc = ConexionDatabase::get_instancia();
$albaran = (new Request())->getParam("albaran_compra");
$registros = $albaran["registros"];
$albaran_q = <<<SQL
  INSERT INTO albaranes_compra VALUES (
    :id, :id_serie, :id_proveedor, STR_TO_DATE(:fecha, "%d-%m-%Y"), :id_albaran_proveedor,
    :id_metodo_pago, :descuento_general, :id_serie_factura, :id_factura)
    ON DUPLICATE KEY UPDATE id_proveedor = :id_proveedor, fecha = STR_TO_DATE(:fecha, "%d-%m-%Y"),
    id_albaran_proveedor = :id_albaran_proveedor, id_metodo_pago = :id_metodo_pago,
    descuento_general = :descuento_general, id_serie_factura = :id_serie_factura, id_factura = :id_factura;
SQL;

$registro_q = <<<SQL
  INSERT INTO registros_albaran_compra VALUES (
    :n, :id_serie_albaran, :id_albaran, :id_articulo, :nombre_registro, :iva,
    :cantidad_master, :precio_coste, :descuento, :cantidad)
    ON DUPLICATE KEY UPDATE n = :n, id_serie_albaran = :id_serie_albaran, id_albaran = :id_albaran,
    id_articulo = :id_articulo, nombre_registro = :nombre_registro, iva = :iva,
    cantidad_master = :cantidad_master, precio_coste = :precio_coste, descuento = :descuento,
    cantidad = :cantidad;
SQL; 
//// TRIGGER BEFORE UPDATE DELETE TODOS LOS REGISTROS ANTES ACTUALIZAR EL ALBARAN.
$albaran_stm = $dbc->prepare($albaran_q);
$albaran_stm->bindValue(":id", $albaran["id"], PDO::PARAM_INT);
$albaran_stm->bindValue(":id_serie", $albaran["id_serie"], PDO::PARAM_INT);
$albaran_stm->bindValue(":id_proveedor", $albaran["id_proveedor"], PDO::PARAM_INT);
$albaran_stm->bindValue(":fecha", $albaran["fecha"], PDO::PARAM_STR);
$albaran_stm->bindValue(":id_albaran_proveedor", $albaran["id_albaran_proveedor"], PDO::PARAM_STR);
$albaran_stm->bindValue(":id_metodo_pago", $albaran["id_metodo_pago"], PDO::PARAM_STR);
$albaran_stm->bindValue(":descuento_general", $albaran["descuento_general"], PDO::PARAM_STR);
$albaran_stm->bindValue(":id_serie_factura", null, PDO::PARAM_NULL);
$albaran_stm->bindValue(":id_factura", null, PDO::PARAM_NULL);
$albaran_stm->execute();

foreach ( $registros as $n => $reg ) {
  $reg_stm = $dbc->prepare($registro_q);
  $reg_stm->bindValue(":n", $n, PDO::PARAM_INT);
  $reg_stm->bindValue(":id_serie_albaran", $albaran["id_serie"], PDO::PARAM_INT);
  $reg_stm->bindValue(":id_albaran", $albaran["id"], PDO::PARAM_INT);
  $reg_stm->bindValue(":id_articulo", $reg["id_articulo"], PDO::PARAM_INT);
  $reg_stm->bindValue(":nombre_registro", $reg["nombre_registro"], PDO::PARAM_STR);
  $reg_stm->bindValue(":iva", $reg["iva"], PDO::PARAM_STR);
  $reg_stm->bindValue(":cantidad_master", $reg["cantidad_master"], PDO::PARAM_STR);
  $reg_stm->bindValue(":precio_coste", $reg["precio_coste"], PDO::PARAM_STR);
  $reg_stm->bindValue(":descuento", $reg["descuento"], PDO::PARAM_STR);
  $reg_stm->bindValue(":cantidad", $reg["cantidad"], PDO::PARAM_STR);
  $reg_stm->execute();
}

?>