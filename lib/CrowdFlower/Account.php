<?php

namespace CrowdFlower;

class Account extends Base
{
  protected $baseUrl = "https://api.crowdflower.com/v1/";

  public function __construct($param)
  {
    if (is_string($param)) {
      $apiKey = $param;
      $this->request = new Request($apiKey, $this->baseUrl);
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
      $job = new Job($jsonjob->id, $jsonjob, $this->request);
      $jobs[] = $job;
    }
    return $jobs;
  }

  public function createJob($attributes = null){
    $job = new Job(null, null, $this->request);
    print_r($job);
    if($attributes !== null){
      $job->setAttributes($attributes);
    }
    print_r($job->create());
    return $job;
  }
}
