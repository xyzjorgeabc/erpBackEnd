<?php

class Request {

  private $dominio;
  private $ubicacion;
  private $metodo;
  private $params;
  private $cookies;

  public function __construct(){

    $this->dominio   = $_SERVER['HTTP_HOST'];
    $this->ubicacion = $_SERVER['REQUEST_URI'];
    $this->metodo    = $_SERVER['REQUEST_METHOD'];
    $this->params    = json_decode(file_get_contents('php://input'), true);
    $this->cookies   = $_COOKIE;
    
  }
  public function getURL(): string {
    return $this->dominio.$this->ubicacion;
  }
  public function getDominio(): string {
    return $this->dominio;
  }
  public function getUbicacion(): string {
    return $this->ubicacion;
  }
  public function getMetodo(): string {
    return $this->metodo;
  }
  public function getParam(string $nom) {
    return $this->params[$nom];
  }
}

?>