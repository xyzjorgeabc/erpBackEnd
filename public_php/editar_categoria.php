<?php
require_once __DIR__.'/../request.php';
require_once __DIR__.'/../db.php';

$dbc = ConexionDatabase::get_instancia();
$categoria = (new Request())->getParam("categoria");

$q = <<<SQL
  INSERT INTO categorias
  VALUES( :id, :nombre, :descripcion, :iva_por_defecto )
  ON DUPLICATE KEY UPDATE nombre = :nombre, descripcion = :descripcion,
  iva_por_defecto = :iva_por_defecto;
SQL;

$categoria_stm = $dbc->prepare($q);
$categoria_stm->bindValue(":id", $categoria["id"], PDO::PARAM_INT);
$categoria_stm->bindValue(":nombre", $categoria["nombre"], PDO::PARAM_STR);
$categoria_stm->bindValue(":descripcion", $categoria["descripcion"], PDO::PARAM_STR);
$categoria_stm->bindValue(":iva_por_defecto", $categoria["iva_por_defecto"], PDO::PARAM_STR);
$categoria_stm->execute();
?>