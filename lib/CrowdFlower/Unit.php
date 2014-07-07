<?php

namespace CrowdFlower;

/**
 *
 */
class Unit extends CrowdFlower implements CommonInterface
{
  private $job_id = null;
  private $id = null;
  private $attributes = null;

  private function __construct($job_id, $id = null){
    $this->setJobId($job_id);
    $this->setId($id);
    $this->setAttributes($this->read());
  }



  public function read(){
    if($this->getId() === null){ return new CrowdFlowerException('unit_id'); }
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("GET", "jobs/" . $this->getJobId() . "/units/" . $this->getId());

  }

  public function create(){
    if($this->getAttributes() === null){ return new CrowdFlowerException('unit_attributes'); }
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("POST", "jobs/" . $this->getJobId() . "/units/", $this->getAttributes());
  }

  public function update(){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }
    if($this->getId() === null){ return new CrowdFlowerException('unit_id'); }
    if($this->getAttributes() === null){ return new CrowdFlowerException('unit_attributes'); }

    return $this->sendRequest("PUT", "jobs/" . $this->getJobId() . "/units/". $this->getId(), $this->getAttributes());
  }

  public function delete(){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }
    if($this->getId() === null){ return new CrowdFlowerException('unit_id'); }

    return $this->sendRequest("DELETE", "jobs/" . $this->getJobId() . "/units/" . $this->getId());
  }

  public function status(){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("GET", "jobs/" . $this->getJobId() . "/units/ping");
  }

  public function cancel(){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }
    if($this->getId() === null){ return new CrowdFlowerException('unit_id'); }

    return $this->sendRequest("PUT", "jobs/" . $this->getJobId() . "/units/" . $this->getId() . "/cancel");
  }


  public function split($on, $with = " "){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/" . $this->getJobId() . "/units/split);
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

}
