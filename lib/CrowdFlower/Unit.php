<?php

namespace CrowdFlower;

/**
 *
 */
class Unit extends Base implements CommonInterface
{
  protected $object_type = 'unit';
  protected $read_only = Array(
    "created_at",
    "id",
    "judgments_count",
    "updated_at"
  );

  public function __construct(Request $request, $job_id, $id = null, $attributes = array())
  {
    $this->request = $request;
    $this->setJobId($job_id);

    if ($id !== null) {
      $this->setId($id);

      if ($attributes) {
        $this->setAttributes($attributes, 0);
      } else {
        $this->read();
      }
    }
  }



  private function read()
  {
    if ($this->getId() === null) { throw new CrowdFlowerException('unit_id'); }
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/units/" . $this->getId() . ".json";

    $response = $this->sendRequest("GET", $url);

    $this->setAttributes($response, 0);

    return $response;
  }

  public function create($attributes = array())
  {
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/units.json";
    $parameters = $this->serializeAttributes($attributes);
    $attributes = $this->sendRequest("POST", $url, $parameters);

    $this->setAttributes($attributes, 0);

    return $this;

  }

  public function update()
  {
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }
    if ($this->getId() === null) { throw new CrowdFlowerException('unit_id'); }
    if ($this->getAttributesChanged() === null) { throw new CrowdFlowerException('unit_attributes'); }

    $url = "jobs/" . $this->getJobId() . "/units/" . $this->getId() . ".json";
    $parameters = $this->serializeAttributes($this->getAttributesChanged());

    $this->resetAttributesChanged();

    return $this->sendRequest("PUT", $url, $parameters);
  }

  public function delete()
  {
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }
    if ($this->getId() === null) { throw new CrowdFlowerException('unit_id'); }

    $url = "jobs/" . $this->getJobId() . "/units/" . $this->getId() . ".json";

    return $this->sendRequest("DELETE", $url);
  }

  public function cancel()
  {
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }
    if ($this->getId() === null) { throw new CrowdFlowerException('unit_id'); }

    $url = "jobs/" . $this->getJobId() . "/units/" . $this->getId() . "/cancel.json";

    return $this->sendRequest("PUT", $url);
  }


  public function split($on, $with = " ")
  {
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/units/split.json";
    $parameters = "on=" . urlencode($on) . "&with=" . urlencode($with);


    return $this->sendRequest("PUT", $url, $parameters);
  }

  public function createJudgment($attributes = array())
  {
    $judgment = new Judgment($this->request, $this->getJobId(), $this->getId());
    $judgment->create($attributes);
    return $judgment;
  }

  public function createJudgments($attributes_array)
  {
    foreach($attributes_array as $k => $attributes){
      $judgments[] = $this->createJudgment($attributes);
    }
    return $judgments;
  }


  public function getJudgments()
  {
    $url = "jobs/" . $this->getJobId() . "/units/" . $this->getId() . "/judgments.json";
    $response = $this->sendRequest("GET", $url);
    $judgments = Array();
    foreach ((array) $response as $jsonjudgment) {
      $this->judgments[] = new Judgment($this->request, $this->getJobId(), $this->getId(), $jsonjudgment->id, $jsonjudgment);
    }

    return $this->judgments;
  }

  private function setJobId($job_id)
  {
    $this->attributes['job_id'] = $job_id;
    return true;
  }

  public function getJobId()
  {
    return $this->attributes['job_id'];
  }
}
