<?php
require_once __DIR__.'/../request.php';
require_once __DIR__.'/../db.php';

$dbc = ConexionDatabase::get_instancia();
$albaran_req = (new Request())->getParam("albaran_compra");

$albaran_q = <<<SQL
  SELECT *, DATE_FORMAT(fecha, "%d-%m-%Y") as fecha FROM albaranes_compra 
  WHERE id_serie = :id_serie AND id = :id;
SQL;

$registros_q = <<<SQL
  SELECT * FROM registros_albaran_compra 
  WHERE id_albaran = :id_albaran AND id_serie_albaran = :id_serie_albaran ORDER BY n ASC;
SQL;

$albaran_stm = $dbc->prepare($albaran_q);
$albaran_stm->bindValue(":id_serie", $albaran_req["id_serie"], PDO::PARAM_INT);
$albaran_stm->bindValue(":id", $albaran_req["id"], PDO::PARAM_INT);
$albaran_stm->execute();
$res_albaran = $albaran_stm->fetchAll()[0];

$registros_stm = $dbc->prepare($registros_q);
$registros_stm->bindValue(":id_serie_albaran", $albaran_req["id_serie"], PDO::PARAM_INT);
$registros_stm->bindValue(":id_albaran", $albaran_req["id"], PDO::PARAM_INT);
$registros_stm->execute();
$res_albaran["registros"] = $registros_stm->fetchAll();

echo json_encode($res_albaran);

?>