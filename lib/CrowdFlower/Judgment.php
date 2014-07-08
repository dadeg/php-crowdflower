<?php

namespace CrowdFlower;

/**
 *
 */
class Judgment extends Base implements CommonInterface
{
  private $job_id = null;
  private $id = null;
  private $attributes = null;

  private function __construct($job_id, $id = null){
    $this->setJobId($job_id);
    if($id !== null){
      $this->setId($id);
      $this->setAttributes($this->read());
    }
  }



  public function read($limit = "", $page = ""){
    if($this->getId() === null){ return new CrowdFlowerException('judgment_id'); }
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId();
    $parameters = "limit=" . urlencode($limit) . "&page=" . urlencode($page);
    $url .= $parameters;

    return $this->sendRequest("GET", $url);

  }

  public function create(){
    if($this->getAttributes() === null){ return new CrowdFlowerException('judgment_attributes'); }
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/?";
    $parameters = $this->serializeAttributes($this->getAttributes());
    $url .= $parameters;

    return $this->sendRequest("POST", $url);
  }

  public function update(){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }
    if($this->getId() === null){ return new CrowdFlowerException('judgment_id'); }
    if($this->getAttributes() === null){ return new CrowdFlowerException('judgment_attributes'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . "?";
    $parameters = $this->serializeAttributes($this->getAttributes());
    $url .= $parameters;

    return $this->sendRequest("PUT", $url);
  }

  public function delete(){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }
    if($this->getId() === null){ return new CrowdFlowerException('judgment_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId();

    return $this->sendRequest("DELETE", $url);
  }

  public function download($full = true){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId();

    return $this->sendRequest("GET", $url);
  }

  public function getUnit(){
    $unit = new Unit($this->attributes['job_id'], $this->attributes['unit_id']);
    return $unit;
  }

  private function setJobId($job_id){
    $this->job_id = $job_id;
    return true;
  }

  public function getJobId(){
    return $this->job_id;
  }


  public function setId($id){
    $this->id = $id;
    return true;
  }

  public function getId(){
    return $this->id;
  }

  public function setAttributes($data){
    $this->attributes = $data;
    return true;
  }

  public function getAttributes(){
    return $this->attributes;
  }



  private function serializeAttributes($parameters){
    $parameters_str = "";
    $i = 0;
    foreach($parameters as $k => $v){
      if($i++ > 0){
        $parameters_str .= "&";
      }
      $parameters_str .= "judgment[" . urlencode($k) . "]=" . urlencode($v);
    }
    return $parameters_str;
  }
}
