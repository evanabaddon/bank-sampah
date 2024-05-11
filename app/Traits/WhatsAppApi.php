<?php

namespace App\Traits;

trait WhatsAppApi
{
    public function sendMessage($receiver, $message)
    {
        $api = settings()->get('wa_api');
        
        $body = array(
            "api_key" => $api,
            "receiver" => $receiver,
            "data" => array("message" => $message)
          );
          
          $curl = curl_init();
          curl_setopt_array($curl, [
            CURLOPT_URL => "https://wa.bumdespringgondani.com/api/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => [
              "Accept: */*",
              "Content-Type: application/json",
            ],
          ]);
          
          $response = curl_exec($curl);
          $err = curl_error($curl);
          
          curl_close($curl);
          
          if ($err) {
            return "cURL Error #:" . $err;
          } else {
            return $response;
          }
    
    }
}

?>
