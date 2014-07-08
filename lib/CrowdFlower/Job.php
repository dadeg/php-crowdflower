<?php

namespace CrowdFlower;

/**
 *
 *
 *
 */
class Job extends Base implements CommonInterface
{
  private $id = null;
  private $attributes = null;
  private $units = Array();

  public function __construct($id = null){
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

//TODO: add upload parameter and file handling
  public function upload($data){
    $url = "jobs/";
    if($this->getId() !== null){
      $url .= $this->getId();
    }
    return $this->sendRequest("PUT", $url, $data);
  }

  public function copy($all_units = false, $gold = false){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getId() . "/copy?";
    $parameters = "all_units=" . urlencode($all_units) . "&gold=" . urlencode($gold);
    $url .= $parameters;

    return $this->sendRequest("POST", $url);
  }

  public function pause(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/pause");
  }

  public function resume(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/resume");
  }

  public function cancel(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/cancel");
  }

  public function status(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("GET", "jobs/".$this->getId()."/ping");
  }

  public function resetGold(){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }
    $url = "jobs/".$this->getId()."/gold?";
    $parameters = "reset=true";
    $url .= $parameters;
    return $this->sendRequest("PUT", $url);
  }

  public function setGold($check, $with = false){
    if($this->getId() === null){ return new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getId() . "/gold?";
    $parameters = "convert_units=true&check=" . urlencode($check);
    if($with !== false){
      $parameters .= "&with=" . urlencode($with);
    }
    $url .= $parameters;

    return $this->sendRequest("PUT", $url);
  }

  public function getUnits(){
    $url = "jobs/" . $this->getId() . "/units";
    return $this->sendRequest("GET", $url);
  }

  public function createUnit($attributes){
    $unit = new Unit();
    $unit->setAttributes($attributes);
    $unit->create();
    $this->units[] = $unit;
    return $unit;
  }

  public function createUnits($attributes_array){
    foreach($attributes_array as $k => $attributes){
      $units[] = $this->createUnit($attributes);
    }
    return $units;
  }

  public function createOrder($numUnits, $channels){
    $order = new Order();
    return $order->create($numUnits, $channels);
  }

  public function getJudgments(){
    $url = "jobs/" . $this->getId() . "/judgments";
    return $this->sendRequest("GET", $url);
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
      $parameters_str .= "job[" . urlencode($k) . "]=" . urlencode($v);
    }
    return $parameters_str;
  }




}
