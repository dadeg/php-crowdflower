# PHP Crowdflower API integration.
[![Code Climate](https://codeclimate.com/github/dadeg/php-crowdflower.png)](https://codeclimate.com/github/dadeg/php-crowdflower)
[![Build Status](https://travis-ci.org/dadeg/php-crowdflower.svg?branch=master)](https://travis-ci.org/dadeg/php-crowdflower)
## Currently under heavy development

## Installation
### Add to composer.json
```
  "dadeg/php-crowdflower": "v0.1.*"
```

### Update composer for existing projects
```bash
  composer update dadeg/php-crowdflower
```

### Composer install for new projects
```bash
  composer install
```

## Getting Started
```php
use CrowdFlower\Account;
$crowd = new Account($apiKey);
```

## Getting existing Jobs
```php
// get list of available jobs from account
$jobs = $crowd->getJobs();

// get job by job id
$job = $crowd->getJob($jobId);
```

## Creating new Jobs
```php
// create empty job
$job = $crowd->createJob();

// create job with job info
$job = $crowd->createJob(array(
    "title" => "A brand new job"
));

// jobs can also be created from a copy of an existing job
$jobCopy = $crowd->getJob($jobId)->copy();
```

## Adding Units
```php
// create units from a file (This feature is not yet available)
$units = $job->createUnits('crowdflower.csv');

// create units from json (This feature is not yet available)
$units = $job->createUnits('[{"sky_color": "blue"}, {"grass_color": "green"}]');

// create units from array
$units = $job->createUnits(array(
    array('sky_color' => 'blue'),
    array('grass_color' => 'green')
));

// units can also be created individually
$unit = $job->createUnit(array('sky_color' => 'blue'));

// or they can be created with a job (This feature may not be stable)
$job = $crowd->createJob(array(
    "units" => '[{"sky_color": "blue"}, {"grass_color": "green"}]'
));
```

## Adding Orders
```php
// jobs can create orders
$order = $job->createOrder($numberOfUnits, $channels);
```
