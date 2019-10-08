<?php
require_once __DIR__."/../request.php";
require_once __DIR__."/../db.php";

$dbc = ConexionDatabase::get_instancia();
$proveedor = (new Request())->getParam("proveedor");
$q = <<<SQL
  INSERT INTO proveedores 
  VALUES( :id, :nombre, :cif, :persona_contacto, :direccion, :telefono, :fax,
  :id_metodo_pago, :cuenta_bancaria, :sitio_web, :email, :informacion_adicional)
  ON DUPLICATE KEY UPDATE nombre = :nombre, cif = :cif, persona_contacto = :persona_contacto,
  direccion = :direccion, telefono = :telefono, fax = :fax, id_metodo_pago = :id_metodo_pago,
  cuenta_bancaria = :cuenta_bancaria, sitio_web = :sitio_web, email = :email,
  informacion_adicional = :informacion_adicional;
SQL;

$proveedor_stm = $dbc->prepare($q);
$proveedor_stm->bindValue(":id", $proveedor["id"], PDO::PARAM_INT);
$proveedor_stm->bindValue(":nombre", $proveedor["nombre"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":cif", $proveedor["cif"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":persona_contacto", $proveedor["persona_contacto"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":direccion", $proveedor["direccion"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":telefono", $proveedor["telefono"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":fax", $proveedor["fax"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":id_metodo_pago", $proveedor["id_metodo_pago"], PDO::PARAM_INT);
$proveedor_stm->bindValue(":cuenta_bancaria", $proveedor["cuenta_bancaria"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":sitio_web", $proveedor["sitio_web"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":email", $proveedor["email"], PDO::PARAM_STR);
$proveedor_stm->bindValue(":informacion_adicional", $proveedor["informacion_adicional"], PDO::PARAM_STR);
$proveedor_stm->execute();

?>