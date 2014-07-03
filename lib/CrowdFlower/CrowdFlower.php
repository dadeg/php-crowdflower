<?php

namespace CrowdFlower;

abstract class CrowdFlower
{
  protected $key = "";
  protected $base_url = "https://api.crowdflower.com/v1/";
  protected $format = ".json";
  protected $request_type = "";

  /**
   * makes a connection and sends a request to the Crowdflower API
   * @return [type] [description]
   */
  protected function sendRequest($method, $url_modifier, $data=""){
    $url = $this->base_url . $url_modifier . $this->format . "?key=" . $this->key;
    $method;
    $data;
  }

}
