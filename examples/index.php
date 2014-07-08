<?php

require("../lib/CrowdFlower.php");



$apiKey = 'StQNgqJETkBvyvLU-iiK';

$crowd = new CrowdFlower($apiKey);
$jobs = $crowd->getJobs();
print_r($jobs);
print_r("\n");
