<?php

namespace CrowdFlower;

class Webhook
{
    /**
     * accepts $_POST and returns array
     * @param  Array $postdata should be $_POST from the webhook call.
     * @return Array           array of all available data from webhook.
     */
    public function parse($postdata)
    {
        $response['signal'] = $postdata['signal'];
        $response['payload'] = json_decode($postdata['payload']);
        $response['signature'] = $postdata['signature'];
        return $response;
    }
}
