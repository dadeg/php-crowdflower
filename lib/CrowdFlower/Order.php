<?php

namespace CrowdFlower;

/**
 *
 */
class Order extends Base implements CommonInterface
{
  private $job_id = null;
  private $id = null;


  private function __construct($job_id, $id = null){
    $this->setJobId($job_id);
    if($id !== null){
      $this->setId($id);
    }
  }



  public function read(){
    if($this->getId() === null){ return new CrowdFlowerException('judgment_id'); }
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/orders/" . $this->getId();

    return $this->sendRequest("GET", $url);

  }

  public function create($count, $channels = Array("on_demand")){
    if($this->getJobId() === null){ return new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/orders/?";
    $parameters = "debit[units_count]=" . url_encode($count) . "&";
    if(is_string($channels)){
      $parameters .= "channels[]=" . $channels;
    } elseif(is_array($channels)){
      $i = 0;
      foreach($channels as $v = $channel){
        if($i++ > 0){
          $parameters .= "&";
        }
        $parameters .= "channels[]=" . url_encode($channel);
      }
    } else {
      return new CrowdFlowerException('channels must be a string for a single channel or an array for multiple channels.')
    }
    $url .= $parameters;

    return $this->sendRequest("POST", $url);
  }

  public function update(){
    return new CrowdFlowerException('Update not allowed for Orders.');
  }

  public function delete(){
    return new CrowdFlowerException('Delete not allowed for Orders.');
  }



}
