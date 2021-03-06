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
      throw new Exception(
        "Constructor argument must be API key or instance of \CrowdFlower\Request"
      );
    }
  }

  public function getJobs($page = 1)
  {
    if(!is_int($page)) { throw new InvalidArgumentException('getJobs function only accepts integers. Input was: ' . $page); }

    $url = "jobs.json/?page=" . $page;
    $response = $this->sendRequest("GET", $url);

    foreach ($response as $jsonjob) {
      $jobs[] = new Job($this->request, $jsonjob->id, $jsonjob);
    }

    return $jobs;
  }

  public function getJob($id)
  {
    return new Job($this->request, $id);
  }

  public function createJob($attributes = array())
  {
    $job = new Job($this->request);
    $job->create($attributes);

    return $job;
  }
}
