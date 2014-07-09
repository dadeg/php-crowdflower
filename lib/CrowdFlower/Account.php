<?php

namespace CrowdFlower;

class Account extends Base
{
  public function __construct($param)
  {
    if (is_string($param)) {
      $apiKey = $param;
      $this->request = new Request($apiKey);
    } else if ($param instanceof Request) {
      $this->request = $param;
    } else {
      throw new CrowdFlowerException(
        "Constructor argument must be API key or instance of \CrowdFlower\Request"
      );
    }
  }

  public function getJobs($page = 1){
    $url = "jobs.json/?page=" . urlencode($page);
    $response = $this->sendRequest("GET", $url);

    foreach($response as $jsonjob){
      $job = new Job($jsonjob->id, $this->request);
      $job->setAttributes($jsonjob->attributes);
      $jobs[] = $job;
    }
    return $jobs;
  }

  public function createJob($attributes){
    $job = new Job();
    $job->setAttributes($attributes);
    $job->create();
    return $job;
  }
}
