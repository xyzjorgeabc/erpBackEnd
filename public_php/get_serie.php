<?php
require_once __DIR__.'/../request.php';
require_once __DIR__.'/../db.php';

$dbc = ConexionDatabase::get_instancia();
$serie_req = (new Request())->getParam("serie");

if ( $serie_req["id"] === "all") {
  $q = <<<SQL
  SELECT *, DATE_FORMAT(fecha_desde, "%d-%m-%Y") AS fecha_desde, 
  DATE_FORMAT(fecha_hasta, "%d-%m-%Y") AS fecha_hasta FROM series;
SQL;
  $series_stm = $dbc->prepare($q);
  $series_stm->execute();
  $res_series = $series_stm->fetchAll();
  echo json_encode($res_series);
} else if ( $serie_req["id"] === "last" ) {
  $q = <<<SQL
  SELECT *, DATE_FORMAT(fecha_desde, "%d-%m-%Y") AS fecha_desde, 
  DATE_FORMAT(fecha_hasta, "%d-%m-%Y") AS fecha_hasta 
  FROM series ORDER BY id DESC LIMIT 1;
SQL;
  $serie_stm = $dbc->prepare($q);
  $serie_stm->execute();
  $res_serie = $serie_stm->fetchAll();

  if ( count($res_serie) === 1) {
    echo json_encode($res_serie[0]);
  } else {
    http_response_code(404);
  }

} else if ( $serie_req["id"]) {

  $q = <<<SQL
  SELECT *,
  DATE_FORMAT(fecha_desde, "%d-%m-%Y") AS fecha_desde,
  DATE_FORMAT(fecha_hasta, "%d-%m-%Y") AS fecha_hasta
  FROM series WHERE id = :id;
SQL;

  $serie_stm = $dbc->prepare($q);
  $serie_stm->bindValue(":id", $serie_req["id"], PDO::PARAM_INT);
  $serie_stm->execute();
  $res_serie = $serie_stm->fetchAll();

  if ( count($res_serie) === 1 ) {
    echo json_encode($res_serie[0]);
  } else {
    http_response_code(404);
  }

}