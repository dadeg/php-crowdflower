<?php

namespace CrowdFlower;

class Job extends Base
{
  protected $objectType = 'job';
  protected $units = array();
  protected $judgments = array();
  protected $channels = array();

  protected $readOnly = array(
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
        $this->setAttributes($attributes, 0);
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

    $this->setAttributes($attributes, 0);

    return $this;
  }

  public function update()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }
    if ($this->getAttributesChanged() === null) { throw new Exception('job_attributes'); }

    $url = "jobs/" . $this->getId() . ".json";

    $attributes = $this->serializeAttributes($this->getAttributesChanged());

    $this->resetAttributesChanged();

    $attributes = $this->sendRequest("PUT", $url, $attributes);
    $this->setAttributes($attributes, 0);

    return $this;
  }

  public function delete()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $response = $this->sendRequest("DELETE", "jobs/".$this->getId() . ".json");

    return true;
  }

//TODO: add upload parameter and file handling
  public function upload($data){
    $url = "jobs.json/";
    if ($this->getId() !== null) {
      $url .= $this->getId();
    }
    return $this->sendRequest("PUT", $url, $data);
  }

  public function copy($allUnits = false, $gold = false){
    if ($this->getId() === null) { throw new Exception('job_id'); }

    //stringify true/false for their api. 1 and 0 does not work.
    if ($allUnits) {
      $allUnits = "true";
    } else {
      $allUnits = "false";
    }
    if ($gold) {
      $gold = "true";
    } else {
      $gold = "false";
    }


    $url = "jobs/" . $this->getId() . "/copy.json?";
    $parameters = "all_units=" . urlencode($allUnits) . "&gold=" . urlencode($gold);
    $url .= $parameters;

    // API docs say to POST this, but their curl examples show a GET. both work.
    $response = $this->sendRequest("GET", $url);

    $job2 = new Job($this->request, $response->id, $response);

    return $job2;
  }

  public function pause()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/pause.json");
  }

  public function resume()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/resume.json");
  }

  public function cancel()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    return $this->sendRequest("PUT", "jobs/".$this->getId()."/cancel.json");
  }

  public function status()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    return $this->sendRequest("GET", "jobs/".$this->getId()."/ping.json");
  }

  public function resetGold()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }
    $url = "jobs/".$this->getId()."/gold.json?";
    $parameters = "reset=true";
    $url .= $parameters;
    return $this->sendRequest("PUT", $url);
  }

  public function setGold($check, $with = false)
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $url = "jobs/" . $this->getId() . "/gold.json?";
    $parameters = "convert_units=true&check=" . urlencode($check);
    if ($with !== false) {
      $parameters .= "&with=" . urlencode($with);
    }
    $url .= $parameters;

    return $this->sendRequest("PUT", $url);
  }

  public function getUnits()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $url = "jobs/" . $this->getId() . "/units.json";

    $response = $this->sendRequest("GET", $url);
    foreach ($response as $jsonunit) {
      $this->units[] = new Unit($this->request, $this->getId(), $jsonunit->id, $jsonunit);
    }
    return $this->units;
  }

  public function getUnit($unitId)
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $unit = new Unit($this->request, $this->getId(), $unitId);

    return $unit;
  }

  public function createUnit($attributes = array())
  {
    $unit = new Unit($this->request, $this->getId());
    $unit->create($attributes);
    return $unit;
  }

  public function createUnits($attributesArray)
  {
    foreach ($attributesArray as $k => $attributes) {
      $units[] = $this->createUnit($attributes);
    }
    return $units;
  }

  public function unitsStatus()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $url = "jobs/" . $this->getId() . "/units/ping.json";

    return $this->sendRequest("GET", $url);
  }

  public function createOrder($numUnits = 0, $channels = "on_demand")
  {
    $order = new Order($this->request, $this->getId());
    return $order->create($numUnits, $channels);
  }

  public function getJudgments()
  {
    $url = "jobs/" . $this->getId() . "/judgments.json";
    $response = $this->sendRequest("GET", $url);
    foreach ((array) $response as $jsonjudgment) {
      $this->judgments[] = new Judgment($this->request, $this->getId(), $jsonjudgment->unit_id, $jsonjudgment->id, $jsonjudgment);
    }
    return $this->judgments;
  }

  public function downloadJudgments($full = true)
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $url = "jobs/" . $this->getId() . ".csv";

    return $this->sendRequest("GET", $url);
  }

  public function getJudgment($judgmentId)
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $judgment = new Judgment($this->request, $this->getId(), $judgmentId);

    return $judgment;
  }
// TODO: channel methods do not seem to work.
  public function getChannels()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $this->channels = $this->sendRequest("GET", "jobs/".$this->getId()."/channels.json");

    return $this->channels;
  }

  public function setChannels($data)
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }
    if (is_string($data)) {
      $parametersStr = 'channels[]=' . urlencode($data);
    } elseif (is_array($data)) {
      $parametersStr = "";
      $i = 0;
      foreach($parameters as $k => $v){
        if($i++ > 0){
          $parametersStr .= "&";
        }
        //convert value to json if it is an object or array.
        if(is_array($v) || is_object($v)){
          $v = json_encode($v);
        }

        $parametersStr .= "channels[]=" . urlencode($v);
      }
    }

    $this->sendRequest("PUT", "jobs/".$this->getId()."/channels.json", $parametersStr);

    $this->channels = $data;

    return true;
  }



  private function read()
  {
    if ($this->getId() === null) { throw new Exception('job_id'); }

    $response = $this->sendRequest("GET", "jobs/".$this->getId() . ".json");

    $this->setAttributes($response, 0);

    return $response;

  }
}
