<?php
require_once __DIR__.'/db.php';
const USUARIO_VISOR  = "visor";
const USUARIO_EDITOR = "editor";
const USUARIO_ADMMIN = "admin";

function autenticar (string $usr, string $pssw): ?array {

  $dbc = ConexionDatabase::get_instancia();
  $usuario_stm = $dbc->prepare("SELECT * FROM usuarios WHERE nombre = ? AND contrasena = ?");
  $usuario_stm->bindParam(1, $usr, PDO::PARAM_STR);
  $usuario_stm->bindParam(2, $pssw, PDO::PARAM_STR);
  $usuario_stm->execute();
  $coincidencia = $usuario_stm->fetchAll();
  $usuario_encontrado = count($coincidencia) === 1;
  
  if($usuario_encontrado){
    $id_tipo_usuario = $coincidencia[0]['id_tipo_usuario'];
    $tipo_stm = $dbc->prepare("SELECT * FROM tipos_usuario WHERE id = ?;");
    $tipo_stm->bindParam(1, $id_tipo_usuario, PDO::PARAM_INT);
    $tipo_stm->execute();
    $tipo_usuario = $tipo_stm->fetchAll()[0]["nombre"];

    return [
      "usr" => $coincidencia[0]["nombre"],
      "prv" => $tipo_usuario,
      "cip" => $_SERVER['REMOTE_ADDR'],
      "iat" => time()
    ];
  }
  return null;
}

?>