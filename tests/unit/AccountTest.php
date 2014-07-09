<?php

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

class AccountTest extends \PHPUnit_Framework_TestCase
{
    public function testGetJobs()
    {
        $jobsJson = file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR .
            'fixtures' . DIRECTORY_SEPARATOR . 'jobs.json'
        );

        $account = new \CrowdFlower\Account($this->getMockedRequest($jobsJson));
        $jobs = $account->getJobs();
    }

    private function getMockedRequest($response)
    {
        $request = $this->getMockBuilder('CrowdFlower\Request')
                        ->disableOriginalConstructor()
                        ->setMethods(array('send'))
                        ->getMock();

        $request->expects($this->any())
                ->method('send')
                ->will($this->returnValue($response));

        return $request;
    }
}
