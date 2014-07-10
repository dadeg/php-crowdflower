<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'StQNgqJETkBvyvLU-iiK';

$crowd = new CrowdFlower\Account($apiKey);

//find recent jobs

// $jobs = $crowd->getJobs();
// print_r($jobs);
// print_r("\n");


//create a job with basic attributes

// $attributes = Array (
//         "title" => "Test Title",
//         "instructions" => "Here are some instructions."
//       );
// $job = $crowd->createJob($attributes);
// print_r($job);

//create a job with no attributes
try {
  $job = $crowd->createJob();
  //print_r($job);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
//copy the job
try {
  $job2 = $job->copy();
  print_r($job2);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
//update job2 with some attributes
try {
  $job2->setAttribute('title', 'test title for copied job');
  $job2->update();
  print_r($job2);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// delete job2
try {
  $response = $job2->delete();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// pause job
try {
  $response = $job->pause();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// resume job
try {
  $response = $job->resume();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// cancel job
try {
  $response = $job->cancel();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// status job
try {
  $response = $job->status();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// reset all golds for job
try {
  $response = $job->resetGold();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// set gold for job
try {
  $response = $job->setGold(null);
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// set channels for job
try {
  $response = $job->setChannels('on_demand');
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// get channels for job
try {
  $response = $job->getChannels();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}




// get a single job that should return an error
try {
  $job = $crowd->getJob('123');
  print_r($job);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

