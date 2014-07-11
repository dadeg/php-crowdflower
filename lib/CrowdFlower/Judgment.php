<?php

namespace CrowdFlower;

/**
 *
 */
class Judgment extends Base implements CommonInterface
{

  private $read_only = Array(
    "started_at",
    "created_at",
    "job_id",
    "contributor_id",
    "unit_id",
    "judgment",
    "external_type",
    "rejected",
    "ip",
    "id",
    "data"
  );

  public function __construct(Request $request, $job_id, $unit_id, $id = null, $attributes = array()){
      $this->request = $request;
      $this->setJobId($job_id);
      $this->setUnitId($unit_id);
      if($id !== null){
        $this->setId($id);

        if ($attributes) {
          $this->setAttributes($attributes);
        } else {
          $this->read();
        }
      }
  }



  private function read($limit = "", $page = ""){
    if($this->getId() === null){ throw new CrowdFlowerException('judgment_id'); }
    if($this->getJobId() === null){ throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . ".json?";
    $parameters = "limit=" . urlencode($limit) . "&page=" . urlencode($page);
    $url .= $parameters;

    return $this->sendRequest("GET", $url);

  }

  public function create(){
    /**
     * It seems that creating a judgment does not work, even though it is in their API Docs.
     */
    throw new CrowdFlowerException('Create not allowed for Judgments.');

    if($this->getAttributes() === null){ throw new CrowdFlowerException('judgment_attributes'); }
    if($this->getJobId() === null){ throw new CrowdFlowerException('job_id'); }
    if($this->getUnitId() === null){ throw new CrowdFlowerException('unit_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments.json";

    $parameters = $this->serializeAttributes($this->getAttributes());


    $response = $this->sendRequest("POST", $url, $parameters);

    $this->setAttributes($response);

    return $this;
  }

  public function update(){
    if($this->getJobId() === null){ throw new CrowdFlowerException('job_id'); }
    if($this->getId() === null){ throw new CrowdFlowerException('judgment_id'); }
    if($this->getAttributes() === null){ throw new CrowdFlowerException('judgment_attributes'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . ".json";

    $parameters = $this->serializeAttributes($this->getAttributes());

    return $this->sendRequest("PUT", $url, $parameters);
  }

  public function delete(){
    if($this->getJobId() === null){ throw new CrowdFlowerException('job_id'); }
    if($this->getId() === null){ throw new CrowdFlowerException('judgment_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . ".json";

    return $this->sendRequest("DELETE", $url);
  }



  public function getUnit(){
    $unit = new Unit($this->request, $this->getJobId(), $this->getUnitId());
    return $unit;
  }

  private function setJobId($job_id){
    $this->attributes['job_id'] = $job_id;
    return true;
  }

  public function getJobId(){
    return $this->attributes['job_id'];
  }

  private function setUnitId($unit_id){
    $this->attributes['unit_id'] = $unit_id;
    return true;
  }

  public function getUnitId(){
    return $this->attributes['unit_id'];
  }





  private function serializeAttributes($parameters){
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

      $parameters_str .= "judgment[" . urlencode($k) . "]=" . urlencode($v);
    }
    return $parameters_str;
  }
}
