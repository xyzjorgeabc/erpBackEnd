<?php
require_once __DIR__.'/../request.php';
require_once __DIR__.'/../db.php';

$dbc = ConexionDatabase::get_instancia();
$albaran_req = (new Request())->getParam("albaran_compra");

$albaran_q = <<<SQL
  SELECT id, DATE_FORMAT(fecha, "%d-%m-%Y") as fecha FROM albaranes_compra
  WHERE id_serie = :id_serie;
SQL;

$albaran_q = <<<SQL
  SELECT alb.id, DATE_FORMAT(alb.fecha, "%d-%m-%Y") AS fecha, alb.id_albaran_proveedor, alb.descuento_general, prov.nombre, met.nombre,
  (SELECT SUM( precio_coste * cantidad) AS regimporte FROM registros_albaran_compra reg WHERE reg.id_albaran = alb.id AND reg.id_serie_albaran = alb.id_serie) as importe
  FROM albaranes_compra alb
  INNER JOIN proveedores prov ON alb.id_proveedor = prov.id INNER JOIN metodos_pago met ON alb.id_metodo_pago = met.id WHERE alb.id_serie = :id_serie;
SQL;

$albaran_stm = $dbc->prepare($albaran_q);
$albaran_stm->bindValue(":id_serie", $albaran_req["id_serie"], PDO::PARAM_INT);
$albaran_stm->execute();
$res_albaran = $albaran_stm->fetchAll();

echo json_encode($res_albaran);

?>