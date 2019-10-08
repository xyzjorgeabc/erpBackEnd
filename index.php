<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, responseType");
header("Access-Control-Allow-Methods: POST");
header("Allow: POST");
header("Content-Type: application/json");

switch ($_SERVER['REQUEST_URI']) {
  case '/login':
    require_once __DIR__.'/public_php/login.php';
  break;
  case '/handshake':
    require_once __DIR__.'/public_php/handshake.php';
  break;
  case '/editar/articulo':
    require_once __DIR__.'/public_php/editar_articulo.php';
  break;
  case '/editar/proveedor':
    require_once __DIR__.'/public_php/editar_proveedor.php';
  break;
  case '/editar/cliente':
    require_once __DIR__.'/public_php/editar_cliente.php';
  break;
  case '/editar/categoria':
    require_once __DIR__.'/public_php/editar_categoria.php';
    break;
  case '/editar/albaran_venta':
    require_once __DIR__.'/public_php/editar_albaran_venta.php';
  break;
  case '/editar/factura_venta':
    require_once __DIR__.'/public_php/editar_factura_venta.php';
  break;
  case '/editar/pedido_venta':
    require_once __DIR__.'/public_php/editar_pedido_venta.php';
  break;
  case '/editar/albaran_compra':
    require_once __DIR__.'/public_php/editar_albaran_compra.php';
  break;
  case '/editar/factura_compra':
    require_once __DIR__.'/public_php/editar_factura_compra.php';
  break;
  case '/fetch/articulo':
    require_once __DIR__.'/public_php/get_articulo.php';
  break;
  case '/fetch/proveedor':
    require_once __DIR__.'/public_php/get_proveedor.php';
  break;
  case '/fetch/categoria':
    require_once __DIR__.'/public_php/get_categoria.php';
  break;
  case '/fetch/metodo_pago':
    require_once __DIR__.'/public_php/get_metodo_pago.php';
  break;
  case '/fetch/serie':
    require_once __DIR__.'/public_php/get_serie.php';
  break;
  case '/fetch/cliente':
    require_once __DIR__.'/public_php/get_cliente.php';
  break;
  case '/fetch/albaran_compra':
    require_once __DIR__.'/public_php/get_albaran_compra.php';
  break;
  case '/fetch/global_settings':
    require_once __DIR__.'/public_php/get_global_settings.php';
  break;
  case '/fetch/listar/albaran_compra':
    require_once __DIR__.'/public_php/listar_albaran_compra.php';
  break;
}

?>
