<?php

  require_once __DIR__.'/../libs/JWS.php';
  require_once __DIR__.'/../request.php';
  
  $token = (new Request())->getParam("token");
  echo json_encode(["token_valido" => validar_token($token)]);
?>