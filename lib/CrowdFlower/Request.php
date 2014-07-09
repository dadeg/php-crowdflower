<?php

namespace CrowdFlower;

class Request
{
    /**
     * @param string $apiKey
     */
    public function __construct($apiKey, $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $method request method
     * @param string $urlModifier request path
     * @param array $data request payload
     * @return string JSON
     */
    public function send($method, $urlModifier, $data)
    {
        $url = $this->baseUrl . $urlModifier;
        if (stristr($url, "?")) {
           $url .= "&";
        } else {
            $url .= "?";
        }

        $url .= "key=" . $this->apiKey;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data !== null) {

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Length: ' . strlen($data))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
