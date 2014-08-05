<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'StQNgqJETkBvyvLU-iiK';


/**
 *
 * Instatiate the container that fetches jobs.
 */
$crowd = new CrowdFlower\Account($apiKey);


/**
 *
 * Fetch units for a job.
 */

// Find all of the units
$units = $job->getUnits();

// Or find a single unit by Unit ID
$unitId = 456;

$unit = $job->getUnit($unitId);



/**
 *
 * Create units for a job.
 */

// First get the job we want to add units to.
$jobId = 123;
$job = $crowd->getJob($jobId);
// Units can be created one at a time..
$unit = Array ("data" => Array('column1' => 'name', 'column2' => 'url'));

$job->createUnit($unit);

// or in an array with multiple units.
 $units = Array (
                 Array ("data" => Array('column1' => 'name', 'column2' => 'url')),
                 Array ("data" => Array('column1' => 'name2', 'column2' => 'url2'))
               );

$job->createUnits($units);



/**
 *
 * Update units for a job.
 */

// First update an attribute.
$unit->setAttribute("data", Array('column1' => 'name updated', 'column2' => 'url updated'));
// Then update it on CrowdFlower's service.
$unit->update();

/**
 *
 * Get the status of all units in a job.
 */

$statuses = $job->UnitsStatus();

/**
 *
 * Cancel a unit.
 */

$unit->cancel();

/**
 *
 * Delete a unit.
 */

$unit->delete();
