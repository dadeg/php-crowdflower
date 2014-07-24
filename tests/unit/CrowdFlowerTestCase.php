<?php

use CrowdFlower\Request;

abstract class CrowdFlowerTestCase extends \PHPUnit_Framework_TestCase
{
    private $apiKey = 'StQNgqJETkBvyvLU-iiK';

    protected function getRequest()
    {
        return new Request($this->apiKey, 'https://api.crowdflower.com/v1/');
    }
}
