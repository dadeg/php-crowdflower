<?php

namespace CrowdFlower;

/**
 *
 */
class Judgment extends Base implements CommonInterface
{
  protected $object_type = 'judgment';
  protected $read_only = Array(
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

  public function __construct(Request $request, $job_id, $unit_id = null, $id = null, $attributes = array())
  {
      $this->request = $request;
      $this->setJobId($job_id);

      if ($unit_id !== null) {
        $this->setUnitId($unit_id);
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



  private function read($limit = "", $page = "")
  {
    if ($this->getId() === null) { throw new CrowdFlowerException('judgment_id'); }
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . ".json?";
    $parameters = "limit=" . urlencode($limit) . "&page=" . urlencode($page);
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
    throw new CrowdFlowerException('Create not allowed for Judgments.');

    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }
    if ($this->getUnitId() === null) { throw new CrowdFlowerException('unit_id'); }

    $url = "jobs/" . $this->getJobId() . "/judgments.json";

    $parameters = $this->serializeAttributes($attributes);


    $response = $this->sendRequest("POST", $url, $parameters);

    $this->setAttributes($response, 0);

    return $this;
  }

  public function update()
  {
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }
    if ($this->getId() === null) { throw new CrowdFlowerException('judgment_id'); }
    if ($this->getAttributesChanged() === null) { throw new CrowdFlowerException('judgment_attributes'); }

    $url = "jobs/" . $this->getJobId() . "/judgments/" . $this->getId() . ".json";

    $parameters = $this->serializeAttributes($this->getAttributesChanged());

    $this->resetAttributesChanged();

    return $this->sendRequest("PUT", $url, $parameters);
  }

  public function delete()
  {
    if ($this->getJobId() === null) { throw new CrowdFlowerException('job_id'); }
    if ($this->getId() === null) { throw new CrowdFlowerException('judgment_id'); }

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
