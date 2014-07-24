<?php

use CrowdFlower\Request;

abstract class CrowdFlowerTestCase extends \PHPUnit_Framework_TestCase
{
    protected $testCML = "<p>what is this</p><cml:textarea label='what in the world' class='' instructions='this makes no sense' default='huh' validates='required'/>";

    private $apiKey = 'StQNgqJETkBvyvLU-iiK';

    protected function getRequest()
    {
        return new Request($this->apiKey, 'https://api.crowdflower.com/v1/');
    }
}
