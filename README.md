# PHP Crowdflower API integration.
[![Code Climate](https://codeclimate.com/github/dadeg/php-crowdflower.png)](https://codeclimate.com/github/dadeg/php-crowdflower)
[![Build Status](https://travis-ci.org/dadeg/php-crowdflower.svg?branch=master)](https://travis-ci.org/dadeg/php-crowdflower)

There are examples of every method of interacting with the CrowdFlower API in the examples folder. The tests are almost at full coverage. I use this package daily and it has been reliable. In order to run the tests yourself you will need to replace the API key in tests/fixtures with your own API key.

## Installation
### Add to composer.json
```
  "dadeg/php-crowdflower": "0.1.*"
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
// get list of ten most recent jobs from account
$jobs = $crowd->getJobs();

// get list of ten jobs from account starting at page 2
$jobs = $crowd->getJobs(2);

// get job by job id
$job = $crowd->getJob($jobId);
```

## Creating new Jobs
```php
// create empty job
$job = $crowd->createJob();

// create job with job info
$job = $crowd->createJob(array(
    "title" => "A brand new job",
    "instructions" => "Follow these rules..."
));

// jobs can also be created from a copy of an existing job
$jobCopy = $crowd->getJob($jobId)->copy();
```

## Adding Units
```php
// create units from array
$units = $job->createUnits(array (
  array ("data" => array('column1' => 'value', 'column2' => 'value')),
  array ("data" => array('column1' => 'value2', 'column2' => 'value2'))
));

// units can also be created individually
$unit = $job->createUnit(array('data' => array('column1' => 'value', 'column2' => 'value')));
```

## Adding Orders
```php
// jobs can create orders
$order = $job->createOrder($numberOfUnits, $channels);
```

## Notes
When attributes are updated via the setAttribute() method, the changes are
tracked and only those are sent to CrowdFlower when an update is made.

The Request object is passed as a dependency in order to properly run tests.
