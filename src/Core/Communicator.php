<?php
/**
* Contains Communicator class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Core;

/**
* Handles request to the API and converts the responses into the data classes.
* @package \IP1\RESTClient\Core
*/
class Communicator
{
    private $accessQuery;

    const DOMAIN = "api.ip1sms.com";
    /**
    * Communicator constructor
    * @param string $accountToken
    * @param string $accessToken
    */
    public function __construct(string $accountToken, string $accessToken)
    {
        $this->accessQuery =  base64_encode($accountToken .":" . $accessToken);
        $this->accessToken = $accessToken;
    }
    public function get(string $endPoint)
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "GET");
    }
    public function post(string $endPoint, ?\JsonSerializable $content)
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        $content = !is_null($content) ? $content : "";
        return $this->sendRequest($parsedEndPoint, "POST", json_encode($content));
    }

    public function delete(string $endPoint): \JsonSerializable
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "DELETE");
    }
    public function put(string $endPoint, ProcessedComponent $content)
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "PUT", json_encode($content));
    }
    private static function parseEndPoint($endPoint)
    {
        if (substr($endPoint, 0, 4) != "api/") {
            $endPoint = "api/" . $endPoint;
        }
        return $endPoint;
    }
    /**
    * Sends a HTTP request to the RESTful API and returns the result as a JSON string
    *
    *   @param string $endPoint    The URI that the function should use.
    *   @param string $method      The HTTP method that should be used, valid ones are: POST, GET, DELETE, PUT.
    *   @param string $content     A JSON string containing all additional data that doesn't belong in $endPoint.
    *   @param bool $https         Whether the the API call should use HTTPS or not(HTTP).
    *   @return string             The response from the API
    */
    private function sendRequest(string $endPoint, string $method, string $content = "", bool $https = false): string
    {
        $options = array(
            'http' => array(
                'header'  => array(
                    'Content-Type: application/json',
                    'Authorization: Basic '. $this->accessQuery
                ),
                'method'  => $method,
                'content' => $content,
            )
        );
        $url = ($https ? "https://" : "http://") . self::DOMAIN . "/" .$endPoint;
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        return $response;
    }
}
