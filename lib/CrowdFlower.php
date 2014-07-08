<?php

Namespace Crowdflower;

Use CommonInterface;
Use Base;
Use CrowdFlowerException;
Use Job;
Use Judgment;
Use Order;
Use Unit;

class CrowdFlower extends Base {

  public function getJobs($page = 1){
    $url = "jobs/?page=" . urlencode($page);
    $response = $this->sendRequest("GET", $url);
    foreach($response as $jsonjob){
      $job = new Job();
      $job->setId($jsonjob['id']);
      $job->setAttributes($jsonjob['attributes']);
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
