<?php

  class ConfigDatabase {
    private static $instancia; 
    private static  $datos;
    private function __construct(){
      
      $rutaConfig = '/config/db.json';
      $json_data = file_get_contents(__DIR__ . $rutaConfig);
      self::$datos = json_decode($json_data, true);
    }
    public static function get_instancia(){
      if(self::$instancia === null){
        self::$instancia = new ConfigDatabase();
      }
      return self::$instancia;
    }
    public function get_config($key = null){
      if ($key === null) {
        return self::$datos;
      }
      else {
        return self::$datos[$key];
      }
    }
  }

  abstract Class ConexionDatabase {
    private static $PDO;
    public static function get_instancia(): PDO{
      if(isset(self::$PDO)){
        return self::$PDO;
      }
      else {
        $config = ConfigDatabase::get_instancia()->get_config();
        $request_conexion = "mysql:host={$config['host']};dbname={$config['nombre']};charset=utf8";
        self::$PDO = new PDO($request_conexion, $config['credenciales']['usuario'], $config['credenciales']['contrasena'], []);
        self::$PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        self::$PDO->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        return self::$PDO;
      }
    }
  }

?>

