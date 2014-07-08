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
    return $this->sendRequest("GET", $url);
  }

  public function createJob($attributes){
    $job = new Job();
    $job->setAttributes($attributes);
    $job->create();
    return $job;
  }
}
