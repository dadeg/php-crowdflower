<?php

namespace CrowdFlower;

abstract class Base
{
  protected $apiKey = "";
  protected $base_url = "https://api.crowdflower.com/v1/";

  public function __construct($apiKey){
    $this->apiKey = $apiKey;
  }
  /**
   * makes a connection and sends a request to the Crowdflower API
   * @return [type] [description]
   * TODO: replace with guzzle?
   */
  protected function sendRequest($method, $url_modifier, $data=null){
    $url = $this->base_url . $url_modifier;
    if(stristr($url, "?")){
      $url .= "&";
    } else {
      $url .= "?";
    }
    $url .= "key=" . $this->apiKey;



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

  public function __call($name, $arguments)
  {
    $prefix = substr($name, 0, 3);
    $attribute = substr($name, 3);
    $attribute = strtolower(preg_replace("[A-Z]", "_\$1", $attribute));
    if ($prefix == "set"){
      $this->attributes[$attribute] = $arguments;
    }
    if($prefix == "get"){
      return $this->attributes[$attribute];
    }
  }
}
