<?php
namespace Controllers;
class TokenController{
  private $admin = false;

  public function createToken($payload){//$payload = array

    $secret_key = BACKEND_API_KEY;

    $array_header = array('alg' => 'HS256', 'typ' => 'JWT');
    $json_header = json_encode($array_header,JSON_UNESCAPED_SLASHES);
    $encoded_header = base64_encode($json_header);

    $json_payload = json_encode($payload,JSON_UNESCAPED_SLASHES);
    $encoded_payload = base64_encode($json_payload);

    $header_payload = $encoded_header . '.' . $encoded_payload;
    $signature = base64_encode(hash_hmac('sha256', $header_payload, $secret_key, true));
    $jwt_token = $header_payload . '.' . $signature;

    return $jwt_token;
  }
  public function validateToken($headers){
    //TODO: Validación de la expiración del token

    if(!isset($headers['Authorization'])){//No existe Authorization en el header
      $response['message']="No se encuentra autorizado.";
      http_response_code(401);//No autorizado
      echo json_encode($response);
      die();
    }else{//El header viene con un token
      $token = $headers['Authorization'];
      $receivedToken = str_replace('Bearer ','',$token);

      $secret_key = BACKEND_API_KEY;
      $jwt_values = explode('.', $receivedToken);

      $received_signature = $jwt_values[2];
      $receivedHeaderAndPayload = $jwt_values[0] . '.' . $jwt_values[1];
      $resultedsignature = base64_encode(hash_hmac('sha256', $receivedHeaderAndPayload, $secret_key, true));

      if($resultedsignature != $received_signature){//El token no sirve
        $response['message']="No se encuentra autorizado.";
        http_response_code(401);//No autorizado
        echo json_encode($response);
        die();
      }else{//El token es confiable, veo si es admin
        $jsonPayload = base64_decode($jwt_values[1]);
        $payload = json_decode($jsonPayload);
        $this->admin = $payload->admin;
      }
    }
  }

  public function isAdmin(){
    return $this->admin;
  }
}
?>
