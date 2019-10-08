<?php
const SECRET = ')H@McQfTjWnZq4t7w!z%C*F-JaNdRgUk';

function base64UrlEncode ( string $st ): string {
  return rtrim(strtr(base64_encode($st), '+/', '-_'), '=');
}
function base64UrlDecode ( string $st ): string {
  return base64_decode(str_pad(strtr($st, '-_', '+/'), strlen($st) % 4, '=', STR_PAD_RIGHT));    
}

function validar_token (string $token): bool {
  list($header, $payload, $hash) = explode(".", $token);
  $testHash = base64UrlEncode(hash_hmac('sha256', $header.".".$payload, SECRET, true));
  return $testHash === $hash;
}

function encode_token( array $payload ): string {

  $header  = base64UrlEncode(json_encode(["alg" => "HS256", "typ"=> "JWT"]));
  $payload = base64UrlEncode(json_encode($payload));
  $hash    = base64UrlEncode(hash_hmac('sha256', $header.".".$payload, SECRET, true));
  return $header.".".$payload.".".$hash;
}

function decode_token(string $st): array {

  list($header, $payload, $hash) = explode(".", $st);
  $header   = json_decode(base64UrlDecode($header));
  $payload  = json_decode(base64UrlDecode($payload));
  $hash     = base64UrlDecode($hash);

  if($header && $payload && $hash ){ 
    return ["header" => $header, "payload" => $payload, "hash" => $hash];
  }
  return null;
}

?>