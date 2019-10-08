<?php

  require_once __DIR__.'/../control_sesion.php';
  require_once __DIR__.'/../libs/JWS.php';
  require_once __DIR__.'/../request.php';
  
  $request = new Request();
  $token_payload = autenticar( $request->getParam('usuario'), $request->getParam('contrasena') );
  $token = encode_token( $token_payload );
  echo json_encode(["token" => $token]);
?>