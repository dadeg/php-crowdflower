<?php

namespace CrowdFlower;

abstract class Base
{

  protected $attributes = array();
  protected $attributesChanged = array();
  protected $objectType;

  /**
   * makes a connection and sends a request to the Crowdflower API
   * @return [type] [description]
   */
  protected function sendRequest($method, $urlModifier, $data = null)
  {
    $result = $this->request->send($method, $urlModifier, $data);
    $result = json_decode($result);


    if (isset($result->error) || isset($result->notice) || isset($result->errors)) {
      if (isset($result->errors)) {
        $message = "";
        foreach ($result->errors as $k => $v) {
          $message .= $v . ". ";
        }


      } elseif (isset($result->error->message) || isset($result->notice->message)) {
        $message = $result->error->message ?: $result->notice->message;
      } else {
        $message = $result->error ?: $result->notice;
      }

      throw new Exception($message);
    }

    return $result;
  }


  public function getId()
  {
    return $this->getAttribute('id');
  }

  public function setId($id)
  {
    $this->setAttribute('id', $id, 0);
    return true;
  }


  public function setAttribute($attribute, $value, $markChanged = 1)
  {
    $this->attributes[$attribute] = $value;
    if ($markChanged) {
      $this->attributesChanged[$attribute] = $value;
    }
    return true;
  }

  public function setAttributes($data, $markChanged = 1)
  {
    foreach((array) $data as $attribute => $value){
      $this->setAttribute($attribute, $value, $markChanged);
    }

    return true;
  }

  public function getAttribute($attribute)
  {
    return $this->attributes[$attribute];
  }

  public function getAttributes()
  {
    return $this->attributes;
  }

  public function getAttributesChanged()
  {
    return $this->attributesChanged;
  }

  protected function serializeAttributes($parameters)
  {
    $parametersStr = "";
    $i = 0;
    foreach ($parameters as $k => $v) {
      if (in_array($k, $this->readOnly)) {
        continue;
      }
      if ($i++ > 0) {
        $parametersStr .= "&";
      }

      //convert value to json if it is an object or array.
      if (is_array($v) || is_object($v)) {
        $v = json_encode($v);
      }

      $parametersStr .= $this->objectType. "[" . urlencode($k) . "]=" . urlencode($v);
    }
    return $parametersStr;
  }

  public function resetAttributesChanged ()
  {
    $this->attributesChanged = array();
    return true;
  }
}
