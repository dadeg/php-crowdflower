<?php

namespace CrowdFlower;

class Request
{
    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $method request method
     * @param string $urlModifier request path
     * @param array $data request payload
     * @return string JSON
     */
    public function request($method, $urlModifier, $data)
    {
        $url = $this->base_url . $urlModifier;
        if (stristr($url, "?")) {
           $url .= "&";
        } else {
            $url .= "?";
        }

        $url .= "key=" . $this->apiKey;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data !== null) {
            $data = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
