<?php
namespace Controllers;
class TokenController{
  //Podrían ser métodos estáticos, pero hay discución sobre el TDD y los métodos estáticos.
  public function createToken($payload){//$payload = array

    $secret_key = BACKEND_API_KEY;

    $array_header = array('alg' => 'HS256', 'typ' => 'JWT');
    $json_header = json_encode($array_header);
    $encoded_header = base64_encode($json_header);

    $json_payload = json_encode($payload);
    $encoded_payload = base64_encode($json_payload);

    $header_payload = $encoded_header . '.' . $encoded_payload;
    $signature = base64_encode(hash_hmac('sha256', $header_payload, $secret_key, true));
    $jwt_token = $header_payload . '.' . $signature;

    return $jwt_token;
  }
  public function validateToken($token){

    $secret_key = BACKEND_API_KEY;
    $jwt_values = explode('.', $token);
    $recieved_signature = $jwt_values[2];
    $recievedHeaderAndPayload = $jwt_values[0] . '.' . $jwt_values[1];
    $resultedsignature = base64_encode(hash_hmac('sha256', $recievedHeaderAndPayload, $secret_key, true));

    return ($resultedsignature == $recieved_signature)?true:false;
  }
}
?>
