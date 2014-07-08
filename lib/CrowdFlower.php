<?php

namespace CrowdFlower;

require("CrowdFlower/Base.php");
require("CrowdFlower/CommonInterface.php");
require("CrowdFlower/CrowdFlowerException.php");
require("CrowdFlower/Job.php");
require("CrowdFlower/Judgment.php");
require("CrowdFlower/Order.php");
require("CrowdFlower/Request.php");
require("CrowdFlower/Unit.php");



use CommonInterface;
use CrowdFlower\Base;
use CrowdFlowerException;
use Job;
use Judgment;
use Order;
use Unit;
use Request;

class CrowdFlower extends Base {

  public function getJobs($page = 1){
    $url = "jobs/?page=" . urlencode($page);
    $response = $this->sendRequest("GET", $url);
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
