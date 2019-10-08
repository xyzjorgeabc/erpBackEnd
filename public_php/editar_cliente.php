<?php
require_once __DIR__."/../request.php";
require_once __DIR__."/../db.php"; 

$dbc = ConexionDatabase::get_instancia();
$cliente = (new Request())->getParam("cliente");
$q = <<<SQL
  INSERT INTO clientes
  VALUES (:id, :nombre_comercial, :cif, :persona_contacto, :direccion, :telefono, :fax,
          :precio_albaran, :factura_automatica, :id_metodo_pago, :cuenta_bancaria,
          :sitio_web, :email, STR_TO_DATE(:fecha_nacimiento, "%d-%m-%Y"), STR_TO_DATE(:fecha_captacion, "%d-%m-%Y"), :descuento, :informacion_adicional)
  ON DUPLICATE KEY UPDATE
          nombre_comercial = :nombre_comercial, cif = :cif, persona_contacto = :persona_contacto,
          direccion = :direccion, telefono = :telefono, fax = :fax, precio_albaran = :precio_albaran,
          factura_automatica = :factura_automatica, id_metodo_pago = :id_metodo_pago,
          cuenta_bancaria = :cuenta_bancaria, sitio_web = :sitio_web, email = :email,
          fecha_nacimiento = STR_TO_DATE(:fecha_nacimiento, "%d-%m-%Y"), fecha_captacion = STR_TO_DATE(:fecha_captacion, "%d-%m-%Y"),
          descuento = :descuento, informacion_adicional = :informacion_adicional;
SQL;

$cliente_stm = $dbc->prepare($q);
$cliente_stm->bindValue(":id", $cliente["id"], PDO::PARAM_INT);
$cliente_stm->bindValue(":nombre_comercial", $cliente["nombre_comercial"], PDO::PARAM_STR);
$cliente_stm->bindValue(":cif", $cliente["cif"], PDO::PARAM_STR);
$cliente_stm->bindValue(":persona_contacto", $cliente["persona_contacto"], PDO::PARAM_STR);
$cliente_stm->bindValue(":direccion", $cliente["direccion"], PDO::PARAM_STR);
$cliente_stm->bindValue(":telefono", $cliente["telefono"], PDO::PARAM_STR);
$cliente_stm->bindValue(":fax", $cliente["fax"], PDO::PARAM_STR);
$cliente_stm->bindValue(":precio_albaran", $cliente["precio_albaran"], PDO::PARAM_BOOL);
$cliente_stm->bindValue(":factura_automatica", $cliente["factura_automatica"], PDO::PARAM_BOOL);
$cliente_stm->bindValue(":id_metodo_pago", $cliente["id_metodo_pago"], PDO::PARAM_INT);
$cliente_stm->bindValue(":cuenta_bancaria", $cliente["cuenta_bancaria"], PDO::PARAM_STR);
$cliente_stm->bindValue(":sitio_web", $cliente["sitio_web"], PDO::PARAM_STR);
$cliente_stm->bindValue(":email", $cliente["email"], PDO::PARAM_STR);
$cliente_stm->bindValue(":fecha_nacimiento", $cliente["fecha_nacimiento"], PDO::PARAM_STR);
$cliente_stm->bindValue(":fecha_captacion", $cliente["fecha_captacion"], PDO::PARAM_STR);
$cliente_stm->bindValue(":descuento", $cliente["descuento"], PDO::PARAM_STR);
$cliente_stm->bindValue(":informacion_adicional", $cliente["informacion_adicional"], PDO::PARAM_STR);
$cliente_stm->execute();

?>