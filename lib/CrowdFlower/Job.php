<?php

namespace CrowdFlower;

class Job extends Base implements CommonInterface
{
  protected $attributes = null;
  private $units = array();
  private $read_only = Array(
    "completed",
    "completed_at",
    "created_at",
    "gold",
    "golds_count",
    "id",
    "judgments_count",
    "state",
    "units_count",
    "updated_at"
  );

  public function __construct(Request $request, $id = null, $attributes = array())
  {
    $this->request = $request;

    if ($id !== null) {
      $this->setId($id);

      if ($attributes) {
        $this->setAttributes($attributes);
      } else {
        $this->read();
      }
    }
  }

  public function create($attributes = array())
  {
    $url = "jobs.json";
    $attributes = $this->serializeAttributes($attributes);
    $attributes = $this->sendRequest("POST", $url, $attributes);

    $this->setAttributes($attributes);

    return $this;
  }

  public function update()
  {
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }
    if($this->getAttributes() === null){ throw new CrowdFlowerException('job_attributes'); }

    $url = "jobs/" . $this->getId() . ".json";
    $attributes = $this->serializeAttributes($this->getAttributes());
    $attributes = $this->sendRequest("PUT", $url, $attributes);
    $this->setAttributes($attributes);

    return $this;
  }

  public function delete()
  {
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    $response = $this->sendRequest("DELETE", "jobs/".$this->getId() . ".json");

    return $response->message;
  }

//TODO: add upload parameter and file handling
  public function upload($data){
    $url = "jobs.json/";
    if($this->getId() !== null){
      $url .= $this->getId();
    }
    return $this->sendRequest("PUT", $url, $data);
  }

  public function copy($all_units = false, $gold = false){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getId() . "/copy.json?";
    $parameters = "all_units=" . urlencode($all_units) . "&gold=" . urlencode($gold);
    $url .= $parameters;

    $response = $this->sendRequest("POST", $url);

    $job2 = new Job($this->request, $response->id, $response);

    return $job2;
  }

  public function pause(){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/pause.json");
  }

  public function resume(){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/resume.json");
  }

  public function cancel(){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/cancel.json");
  }

  public function status(){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    return $this->sendRequest("GET", "jobs/".$this->getId()."/ping.json");
  }

  public function resetGold(){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }
    $url = "jobs/".$this->getId()."/gold.json?";
    $parameters = "reset=true";
    $url .= $parameters;
    return $this->sendRequest("PUT", $url);
  }

  public function setGold($check, $with = false){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getId() . "/gold.json?";
    $parameters = "convert_units=true&check=" . urlencode($check);
    if($with !== false){
      $parameters .= "&with=" . urlencode($with);
    }
    $url .= $parameters;

    return $this->sendRequest("PUT", $url);
  }

  public function getUnits(){
    $url = "jobs/" . $this->getId() . "/units.json";
    $response = $this->sendRequest("GET", $url);
    $units = Array();
    foreach ((array) $response as $unit_id => $unit_data) {
      $units[] = new Unit($this->request, $this->getId(), $unit_id);
    }
    $this->units = $units;
    return $this->units;
  }

  public function getUnit($key){
    return $this->units[$key];
  }

  public function createUnit($attributes){
    $unit = new Unit($this->request, $this->getId());
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

  public function unitsStatus(){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getId() . "/units/ping.json";

    return $this->sendRequest("GET", $url);
  }

  public function createOrder($numUnits = 0, $channels = "on_demand"){
    $order = new Order($this->request, $this->getId());
    return $order->create($numUnits, $channels);
  }

  public function getJudgments(){
    $url = "jobs/" . $this->getId() . "/judgments.json";
    $response = $this->sendRequest("GET", $url);
    $judgments = Array();
    foreach((array) $response as $jsonjudgment){
      $judgments[] = new Judgment($this->request, $this->getId(), $jsonjudgment->unit_id, $jsonjudgment->id, $jsonjudgment);
    }
    $this->judgments = $judgments;
    return $this->judgments;
  }

  public function downloadJudgments($full = true){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getId() . ".csv";

    return $this->sendRequest("GET", $url);
  }

  public function getId(){
    return $this->attributes['id'];
  }

  public function setId($id){
    $this->attributes['id'] = $id;
    return true;
  }






  public function getChannels(){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    $this->channels = $this->sendRequest("GET", "jobs/".$this->getId()."/channels.json");

    return $this->channels;
  }

  public function setChannels($data){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }
    if(is_string($data)){
      $parameters_str = 'channels[]=' . urlencode($data);
    } elseif (is_array($data)){
      $parameters_str = "";
      $i = 0;
      foreach($parameters as $k => $v){
        if($i++ > 0){
          $parameters_str .= "&";
        }
        //convert value to json if it is an object or array.
        if(is_array($v) || is_object($v)){
          $v = json_encode($v);
        }

        $parameters_str .= "channels[]=" . urlencode($v);
      }
    }

    $this->sendRequest("PUT", "jobs/".$this->getId()."/channels.json", $parameters_str);

    $this->channels = $data;

    return true;
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

      $parameters_str .= "job[" . urlencode($k) . "]=" . urlencode($v);
    }
    return $parameters_str;
  }

  private function read(){
    if($this->getId() === null){ throw new CrowdFlowerException('job_id'); }

    $response = $this->sendRequest("GET", "jobs/".$this->getId() . ".json");

    $this->setAttributes($response);

    return $response;

  }
}
