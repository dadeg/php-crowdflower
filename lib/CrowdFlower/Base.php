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
    $result = json_decode($result);

    if($result->error || $result->notice){
      if($result->error->message || $result->notice->message){
        $message = $result->error->message ?: $result->notice->message;
      } else {
        $message = $result->error ?: $result->notice;
      }

      throw new CrowdFlowerException($message);
    }

    return $result;
  }


  public function getId(){
    return $this->attributes['id'];
  }

  public function setId($id){
    $this->attributes['id'] = $id;
    return true;
  }


  public function setAttribute($attribute, $value){
    $this->attributes[$attribute] = $value;
    return true;
  }

  public function setAttributes($data){
    foreach((array) $data as $attribute => $value){
      $this->setAttribute($attribute, $value);
    }

    return true;
  }

  public function getAttribute($attribute){
    return $this->attributes[$attribute];
  }

  public function getAttributes(){
    return $this->attributes;
  }
}
