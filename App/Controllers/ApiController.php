<?php
    namespace App\Controllers;

    Class ApiController{
      public $url;
      public $method;
      public $params;
      public $token;
      public $http_status;
      public $bearer=true;

      public function hitEndPoint(){
        //Falta implementar try/catch para éste tipo de llamadas
        $headers = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_PORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $this->url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->params));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers[] = 'Content-Type: application/json';
        if($this->bearer and !empty($this->token)){
          $headers[] = "Authorization: Bearer ".$this->token;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->http_status = $httpcode;
        curl_close($ch);
        return $result;
      }
    }
 ?>
