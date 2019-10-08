<?php
require_once __DIR__.'/../request.php';
require_once __DIR__.'/../db.php';

$dbc = ConexionDatabase::get_instancia();
$cliente_req = (new Request())->getParam("cliente");

if ( $cliente_req["id"] === "all" ) {
  $q = <<<SQL
  SELECT *,
  DATE_FORMAT(fecha_captacion, "%d-%m-%Y") AS fecha_captacion,
  DATE_FORMAT(fecha_nacimiento, "%d-%m-%Y") AS fecha_nacimiento
  FROM clientes;
SQL;
  $clientes_stm = $dbc->prepare($q);
  $clientes_stm->execute();
  $res_clientes = $clientes_stm->fetchAll();
  echo json_encode($res_clientes);
} else if ($cliente_req["id"] === "last") {
  $q = <<<SQL
  SELECT *,
  DATE_FORMAT(fecha_captacion, "%d-%m-%Y") AS fecha_captacion,
  DATE_FORMAT(fecha_nacimiento, "%d-%m-%Y") AS fecha_nacimiento
  FROM clientes ORDER BY id DESC LIMIT 1;
SQL;
  $cliente_stm = $dbc->prepare($q);
  $cliente_stm->execute();
  $res_cliente = $cliente_stm->fetchAll();
  if (count($res_cliente) === 1) {
    echo json_encode($res_cliente[0]);
  } else {
    http_response_code(404);
  }

} else if ($cliente_req["id"]) {
  $q = <<<SQL
  SELECT *,
  DATE_FORMAT(fecha_captacion, "%d-%m-%Y") AS fecha_captacion,
  DATE_FORMAT(fecha_nacimiento, "%d-%m-%Y") AS fecha_nacimiento
  FROM clientes WHERE id = :id;
SQL;

  $cliente_stm = $dbc->prepare($q);
  $cliente_stm->bindValue(":id", $cliente_req["id"], PDO::PARAM_INT);
  $cliente_stm->execute();
  $res_cliente = $cliente_stm->fetchAll();

  if ( count($res_cliente) === 1 ) {
    echo json_encode($res_cliente[0]);
  } else {
    http_response_code(404);
  }
}

?>