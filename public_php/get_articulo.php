<?php

require_once __DIR__."/../db.php";
require_once __DIR__."/../request.php";

$dbc = ConexionDatabase::get_instancia();
$articulo_req = (new Request())->getParam('articulo');

if($articulo_req["id"] === "all"){
  $articulos_stm = $dbc->prepare("SELECT * FROM articulos;");
  $articulos_stm->execute();
  $articulos = $articulos_stm->fetchAll();
  echo json_encode($articulos);
} else if ($articulo_req["id"] === 'last') {
  $articulo_stm = $dbc->prepare("SELECT * from articulos ORDER BY id DESC LIMIT 1;");
  $articulo_stm->execute();
  $res_articulo = $articulo_stm->fetchAll();
  if (count($res_articulo) === 1) {
    echo json_encode($res_articulo[0]);
  } else {
    http_response_code(404);
  }
} else if($articulo_req["id"]){
  $articulo_stm = $dbc->prepare("SELECT * FROM articulos WHERE id = ?");
  $articulo_stm->bindParam(1, $articulo_req["id"], PDO::PARAM_INT);
  $articulo_stm->execute();
  $res_articulo = $articulo_stm->fetchAll();
  if ( count($res_articulo) === 1 ) {
    echo json_encode($res_articulo[0]);
  } else {
    http_response_code(404);
  }
}

?>