<?php


require("CrowdFlower/Base.php");
require("CrowdFlower/CommonInterface.php");
require("CrowdFlower/CrowdFlowerException.php");
require("CrowdFlower/Job.php");
require("CrowdFlower/Judgment.php");
require("CrowdFlower/Order.php");
require("CrowdFlower/Request.php");
require("CrowdFlower/Unit.php");



use CrowdFlower\CommonInterface;
use CrowdFlower\Base;
use CrowdFlower\CrowdFlowerException;
use CrowdFlower\Job;
use CrowdFlower\Judgment;
use CrowdFlower\Order;
use CrowdFlower\Unit;
use CrowdFlower\Request;

class CrowdFlower extends Base {

  public function getJobs($page = 1){
    $url = "jobs.json/?page=" . urlencode($page);
    $response = $this->sendRequest("GET", $url);

    foreach($response as $jsonjob){
      $job = new Job();
      $job->setId($jsonjob->id);
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
