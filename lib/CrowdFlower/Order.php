<?php

namespace CrowdFlower;

/**
 *
 */
class Order extends Base
{


  public function __construct(Request $request, $job_id, $id = null){
    $this->request = $request;
    $this->setJobId($job_id);
    if($id !== null){
      $this->setId($id);
      $this->read();
    }
  }



  public function read(){
    if($this->getId() === null){ throw new CrowdFlowerException('judgment_id'); }
    if($this->getJobId() === null){ throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/orders.json/" . $this->getId();

    $response = $this->sendRequest("GET", $url);
    $this->setAttributes($response);
    return $this;
  }

  public function create($count = 0, $channels = Array("on_demand")){
    if($this->getJobId() === null){ throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/orders.json?";
    $parameters = "debit[units_count]=" . urlencode($count) . "&";
    if(is_string($channels)){
      $parameters .= "channels[]=" . $channels;
    } elseif(is_array($channels)){
      $i = 0;
      foreach($channels as $v => $channel){
        if($i++ > 0){
          $parameters .= "&";
        }
        $parameters .= "channels[]=" . urlencode($channel);
      }
    } else {
      throw new CrowdFlowerException('channels must be a string for a single channel or an array for multiple channels.');
    }


    $response = $this->sendRequest("POST", $url, $parameters);
    $this->setAttributes($response);
    return $response;
  }

  public function update(){
    throw new CrowdFlowerException('Update not allowed for Orders.');
  }

  public function delete(){
    throw new CrowdFlowerException('Delete not allowed for Orders.');
  }




  public function setJobId($job_id){
    $this->attributes['job_id'] = $job_id;
    return true;
  }

  public function getJobId(){
    return $this->attributes['job_id'];
  }

}
