<?php

require("../lib/CrowdFlower.php");

use CrowdFlower\CrowdFlower;


$apiKey = '123';

print_r(new CrowdFlower($apiKey));
print_r("\n");
