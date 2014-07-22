<?php

namespace CrowdFlower;

/**
 *
 */
class Judgment extends Base
{
  protected $objectType = 'judgment';
  protected $readOnly = Array(
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

  public function __construct(Request $request, $jobId, $unitId = null, $id = null, $attributes = array())
  {
      $this->request = $request;
      $this->setJobId($jobId);

      if ($unit_id !== null) {
        $this->setUnitId($unitId);
      }

      if ($id !== null) {
        $this->setId($id);

        if ($attributes) {
          $this->setAttributes($attributes, 0);
        } else {
          $this->read();
        }
      }
  }



  private function read($limit = 0, $page = 0)
  {
    if(!is_int($limit)) { throw new InvalidArgumentException('Read function only accepts integers. Input was: '.$limit);
    if(!is_int($page)) { throw new InvalidArgumentException('Read function only accepts integers. Input was: '.$page);
    if ($this->getId() === null) { throw new Exception('judgment_id'); }
    if ($this->getJobId() === null) { throw new Exception('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . ".json?";
    $parameters = "limit=" . $limit . "&page=" . $page;
    $url .= $parameters;

    $attributes = $this->sendRequest("GET", $url);

    $this->setAttributes($attributes, 0);

    return $this->getAttributes();

  }

  public function create($attributes = array())
  {
    /**
     * It seems that creating a judgment does not work, even though it is in their API Docs.
     */
    throw new Exception('Create not allowed for Judgments.');

    if ($this->getJobId() === null) { throw new Exception('job_id'); }
    if ($this->getUnitId() === null) { throw new Exception('unit_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments.json";

    $parameters = $this->serializeAttributes($attributes);


    $response = $this->sendRequest("POST", $url, $parameters);

    $this->setAttributes($response, 0);

    return $this;
  }

  public function update()
  {
    if ($this->getJobId() === null) { throw new Exception('job_id'); }
    if ($this->getId() === null) { throw new Exception('judgment_id'); }
    if ($this->getAttributesChanged() === null) { throw new Exception('judgment_attributes'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . ".json";

    $parameters = $this->serializeAttributes($this->getAttributesChanged());

    $this->resetAttributesChanged();

    return $this->sendRequest("PUT", $url, $parameters);
  }

  public function delete()
  {
    if ($this->getJobId() === null) { throw new Exception('job_id'); }
    if ($this->getId() === null) { throw new Exception('judgment_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . ".json";

    return $this->sendRequest("DELETE", $url);
  }



  public function getUnit()
  {
    $unit = new Unit($this->request, $this->getJobId(), $this->getUnitId());
    return $unit;
  }

  private function setJobId($job_id)
  {
    $this->setAttribute('job_id', $job_id, 0);
    return true;
  }

  public function getJobId()
  {
    return $this->getAttribute('job_id');
  }

  private function setUnitId($unit_id)
  {
    $this->setAttribute('unit_id', $unit_id, 0);
    return true;
  }

  public function getUnitId()
  {
    return $this->getAttribute('unit_id');
  }
}
