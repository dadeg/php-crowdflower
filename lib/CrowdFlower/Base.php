<?php

namespace CrowdFlower;

abstract class Base
{

  protected $attributes = array();
  protected $object_type;

  /**
   * makes a connection and sends a request to the Crowdflower API
   * @return [type] [description]
   */
  protected function sendRequest($method, $url_modifier, $data=null)
  {
    $result = $this->request->send($method, $url_modifier, $data);
    $result = json_decode($result);


    if(isset($result->error) || isset($result->notice) || isset($result->errors)){
      if(isset($result->errors)){
        $message = "<ul>";
        foreach($result->errors as $k => $v){
          $message .= "<li>" . $v ."</li>";
        }
        $message .= "</ul>";

      } elseif(isset($result->error->message) || isset($result->notice->message)){
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

  protected function serializeAttributes($parameters){
    $parameters_str = "";
    $i = 0;
    foreach($parameters as $k => $v){
      if(in_array($k, $this->read_only)){
        continue;
      }
      if($i++ > 0){
        $parameters_str .= "&";
      }

      //convert value to json if it is an object or array.
      if(is_array($v) || is_object($v)){
        $v = json_encode($v);
      }

      $parameters_str .= $this->object_type. "[" . urlencode($k) . "]=" . urlencode($v);
    }
    return $parameters_str;
  }
}
