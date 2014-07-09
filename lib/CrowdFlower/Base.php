<?php

namespace CrowdFlower;

abstract class Base
{

  protected $attributes = array();

  /**
   * makes a connection and sends a request to the Crowdflower API
   * @return [type] [description]
   */
  protected function sendRequest($method, $url_modifier, $data=null)
  {
    $result = $this->request->send($method, $url_modifier, $data);

    return json_decode($result);
  }

  public function setAttribute($attribute, $value){
    $this->attributes[$attribute] = $value;
    return true;
  }

  public function getAttribute($attribute){
    return $this->attributes[$attribute];
  }
}
