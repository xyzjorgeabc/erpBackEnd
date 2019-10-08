<?php

require_once __DIR__.'/../request.php';
require_once __DIR__.'/../db.php';

$dbc = ConexionDatabase::get_instancia();
$metodo_pago_req = (new Request())->getParam("metodo_pago");

if ($metodo_pago_req["id"] === 'all') {
  $metodos_pago_stm = $dbc->prepare("SELECT * FROM metodos_pago;");
  $metodos_pago_stm->execute();
  $res_metodos = $metodos_pago_stm->fetchAll();
  echo json_encode($res_metodos);
} else if ($metodo_pago_req["id"] === "last" ) {
  $metodo_pago_stm = $dbc->prepare("SELECT * from metodos_pago ORDER BY id DESC LIMIT 1;");
  $metodo_pago_stm->execute();
  $res_metodo = $metodo_pago_stm->fetchAll();
  if (count($res_metodo) === 1) {
    echo json_encode($res_metodo[0]);
  } else {
    http_response_code(404);
  }
} else if ($metodo_pago_req["id"]) {
  $metodo_pago_stm = $dbc->prepare("SELECT * FROM metodos_pago WHERE id = :id;");
  $metodo_pago_stm->bindValue(":id", $metodo_pago_req["id"], PDO::PARAM_INT);
  $metodo_pago_stm->execute();
  $res_metodo = $metodo_pago_stm->fetchAll();
  if(count($res_metodo) === 1) {
    echo json_encode($res_metodo[0]);
  } else {
    http_response_code(404);
  }
  
}

?>