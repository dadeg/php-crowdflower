<?php

namespace CrowdFlower;

abstract class CrowdFlower
{
  protected $key = "";
  protected $base_url = "https://api.crowdflower.com/v1/";

  /**
   * makes a connection and sends a request to the Crowdflower API
   * @return [type] [description]
   */
  protected function sendRequest($method, $url_modifier, $data=null){
    $url = $this->base_url . $url_modifier . "?key=" . $this->key;



    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if($data !== null){
      $data = json_encode($data);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data))
    );

    $result = curl_exec($ch);

    curl_close($ch);

    return json_decode($result);


  }

}
