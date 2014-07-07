<?php

namespace CrowdFlower;

/**
 * /jobs/upload
 * /jobs/{job_id}/upload
 *
 */
class Job extends CrowdFlower implements CommonInterface
{
  private $id = null;
  private $attributes = null;


  private function __construct($id = null){
    if($id !== null){
      $this->setId($id);
      $this->setAttributes($this->read());
    }
  }


  public function read(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("GET", "jobs/".$this->getId());

  }

  public function create(){
    if($this->getAttributes() === null){ return new CrowdFlowerException('job_attributes'); }

    $parameters = $this->serializeAttributes($this->getAttributes());

    $url = "jobs?" . $parameters;

    return $this->sendRequest("POST", $url);
  }

  public function update(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }
    if($this->getAttributes() === null){ return new CrowdFlowerException('job_attributes'); }

    $parameters = $this->serializeAttributes($this->getAttributes());

    $url = "jobs/".$this->getId() . "?" . $parameters;

    return $this->sendRequest("PUT", $url);
  }

  public function delete(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("DELETE", "jobs/".$this->getId());
  }
//continue here with adding parameters to url correctly
  public function upload($data){
    $url = "jobs/";
    if($this->getId() !== null){
      $url .= $this->getId();
    }
    return $this->sendRequest("PUT", $url, $data);
  }

  public function copy($all_units = false, $gold = false){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    $data['all_units'] = $all_units;
    $data['gold'] = $gold;

    return $this->sendRequest("POST", "jobs/".$this->id."/copy", $data);
  }

  public function pause(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->id."/pause");
  }

  public function resume(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->id."/resume");
  }

  public function cancel(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->id."/cancel");
  }

  public function status(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("GET", "jobs/".$this->id."/ping");
  }

  public function resetGold(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }
    $data['reset'] = true;
    return $this->sendRequest("PUT", "jobs/".$this->id."/gold", $data);
  }

  public function setGold($check, $with = false){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }
    $data['check'] = $check;
    if($with !== false){
      $data['with'] = $with;
    }
    $data['convert_units'] = true;

    return $this->sendRequest("PUT", "jobs/".$this->id."/gold", $data);
  }



  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
    return true;
  }

  public function getAttributes(){
    return $this->attributes;
  }

  public function setAttributes($data){
    $this->attributes = $data;
    return true;
  }


  public function getChannels(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    $this->channels = $this->sendRequest("GET", "jobs/".$this->id."/channels");

    return $this->channels;
  }

  public function setChannels($data){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    $this->sendRequest("PUT", "jobs/".$this->id."/channels", $data);

    $this->channels = $data;

    return true;
  }

  private function serializeAttributes($parameters){
    $parameters_str = "";
    $i = 0;
    foreach($parameters as $k => $v){
      if($i++ > 0){
        $parameters_str .= "&";
      }
      $parameters_str .= "job[" . url_encode($k) . "]=" . url_encode($v);
    }
    return $parameters_str;
  }




}
