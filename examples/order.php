<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'jLByZLxtuyWV9x6g-Msq';

/**
 *
 * Instatiate the container that fetches jobs.
 */
$crowd = new CrowdFlower\Account($apiKey);

// Find a job to create an order for.
$jobId = 123;
$job = $crowd->getJob($jobId);

// Create the order. $numUnits is the number of units. 0 = all. $channels default is 'on_demand'

$numUnits = 0;
$channels = 'cf_internal';
$order = $job->createOrder($numUnits, $channels);
