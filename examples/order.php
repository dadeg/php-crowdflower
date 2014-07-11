<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'StQNgqJETkBvyvLU-iiK';

$crowd = new CrowdFlower\Account($apiKey);

//create a job with no attributes
try {
  $job = $crowd->createJob();
  //print_r($job);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// create an order for this job.
try {
  $response = $job->createOrder(0, "cf_internal");
  //print_r($job);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
