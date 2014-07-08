<?php

namespace CrowdFlower;

abstract class Base
{
  protected $apiKey = "";
  protected $baseUrl = "https://api.crowdflower.com/v1/";

  public function __construct($apiKey)
  {
    $this->request = new Request($apiKey, $this->baseUrl);
  }

  /**
   * makes a connection and sends a request to the Crowdflower API
   * @return [type] [description]
   */
  protected function sendRequest($method, $url_modifier, $data=null)
  {
    $result = $this->request->send($method, $url_modifier, $data);

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
