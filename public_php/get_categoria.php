<?php

require_once __DIR__."/../db.php";
require_once __DIR__."/../request.php";

$dbc = ConexionDatabase::get_instancia();
$categoria_req = (new Request())->getParam("categoria");

if ($categoria_req["id"] === "all") {
  $categorias_stm = $dbc->prepare("SELECT * FROM categorias;");
  $categorias_stm->execute();
  $categorias = $categorias_stm->fetchAll();
  echo json_encode($categorias);
} else if ($categoria_req["id"] === 'last') {
  $categoria_stm = $dbc->prepare("SELECT * FROM categorias ORDER BY id DESC LIMIT 1;");
  $categoria_stm->execute();
  $res_categoria = $categoria_stm->fetchAll();
  if (count($res_categoria) === 1) {
    echo json_encode($res_categoria[0]);
  } else {
    http_response_code(404);
  }
} else if ($categoria_req["id"]) {
  $categoria_stm = $dbc->prepare("SELECT * FROM categorias WHERE id = :id;");
  $categoria_stm->bindParam(":id", $categoria_req["id"], PDO::PARAM_INT);
  $categoria_stm->execute();
  $res_categoria = $categoria_stm->fetchAll();
  
  if (count($res_categoria) === 1) {
    echo json_encode($res_categoria[0]);
  } else {
     http_response_code(404);
  }
}

?>