<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'StQNgqJETkBvyvLU-iiK';

$crowd = new CrowdFlower\Account($apiKey);

//find recent jobs

//$jobs = $crowd->getJobs();
//print_r($jobs);
//print_r("\n");


//create a job with basic attributes
// $job = Array (
//         "title" => "Test Title",
//         "instructions" => "Here are some instructions."
//       );

// $job = $crowd->createJob($job);
// print_r($job);


//create a job with no attributes

$job = $crowd->createJob();
print_r($job);
