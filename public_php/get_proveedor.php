<?php

require_once __DIR__."/../db.php";
require_once __DIR__."/../request.php";

$dbc = ConexionDatabase::get_instancia();
$proveedor_req = (new Request())->getParam('proveedor');

if($proveedor_req['id'] === 'all'){
  $proveedores_stm = $dbc->prepare("SELECT * FROM proveedores;");
  $proveedores_stm->execute();
  $proveedor = $proveedores_stm->fetchAll();
  echo json_encode($proveedor);
} else if ($proveedor_req["id"] === 'last') {
  $proveedor_stm = $dbc->prepare("SELECT * from categorias ORDER BY id DESC LIMIT 1;");
  $proveedor_stm->execute();
  $res_proveedor = $proveedor_stm->fetchAll();
  if (count($res_proveedor) === 1) {
    echo json_encode($res_proveedor[0]);
  } else {
    http_response_code(404);
  }
} else if($proveedor_req['id']){
  $proveedor_stm = $dbc->prepare("SELECT * FROM proveedores WHERE id = :id");
  $proveedor_stm->bindParam(":id", $proveedor_req["id"], PDO::PARAM_INT);
  $proveedor_stm->execute();
  $res_proveedor = $proveedor_stm->fetchAll();
  if (count($res_proveedor) === 1) {
    echo json_encode($res_proveedor[0]);
  } else {
    http_response_code(404);
  }

}

?>
