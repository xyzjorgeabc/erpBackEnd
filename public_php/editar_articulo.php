<?php
require_once __DIR__."/../request.php";
require_once __DIR__."/../db.php";

$dbc = ConexionDatabase::get_instancia();
$articulo = (new Request())->getParam("articulo");

$q = <<<SQL
  INSERT INTO articulos
  VALUES( :id, :nombre, :descripcion, :id_categoria,
  :id_proveedor, :cantidad_master, :iva, :coste_anterior, :coste, :pvp_detalle, :pvp_mayor)
  ON DUPLICATE KEY UPDATE nombre = :nombre, descripcion = :descripcion, id_categoria = :id_categoria,
  id_proveedor = :id_proveedor, cantidad_master = :cantidad_master, iva = :iva,
  coste = :coste,  pvp_detalle = :pvp_detalle, pvp_mayor = :pvp_mayor;
SQL;

$art_update_stm = $dbc->prepare($q);
$art_update_stm->bindValue(":id", $articulo["id"], PDO::PARAM_INT);
$art_update_stm->bindValue(":nombre", $articulo["nombre"], PDO::PARAM_STR);
$art_update_stm->bindValue(":descripcion", $articulo["descripcion"], PDO::PARAM_STR);
$art_update_stm->bindValue(":id_categoria", $articulo["id_categoria"], PDO::PARAM_INT);
$art_update_stm->bindValue(":id_proveedor", $articulo["id_proveedor"], PDO::PARAM_INT);
$art_update_stm->bindValue(":cantidad_master", $articulo["cantidad_master"], PDO::PARAM_STR);
$art_update_stm->bindValue(":iva", $articulo["iva"], PDO::PARAM_STR);
$art_update_stm->bindValue(":coste_anterior", 0, PDO::PARAM_STR);
$art_update_stm->bindValue(":coste", $articulo["coste"], PDO::PARAM_STR);
$art_update_stm->bindValue(":pvp_detalle", $articulo["pvp_detalle"], PDO::PARAM_STR);
$art_update_stm->bindValue(":pvp_mayor", $articulo["pvp_mayor"], PDO::PARAM_STR);
$art_update_stm->execute();

?>