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
* For the available endpoints check out link.
* @link http://api.ip1sms.com/Help
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
    /**
    * Fetches a ProcessedComponent(s) from the given URI.
    * @param string $endPoint API URI
    * @return string JSON API Response
    */
    public function get(string $endPoint)
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "GET");
    }
    /**
    * Adds the content object to the endpoint and returns a processed version of given object.
    * @param string $endPoint API URI
    * @param \JsonSerializable
    * @return string JSON repsonse
    */
    public function post(string $endPoint, ?\JsonSerializable $content)
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        $content = !is_null($content) ? $content : "";
        return $this->sendRequest($parsedEndPoint, "POST", json_encode($content));
    }
    /**
    * Deletes the object
    * @param string $endPoint API URI
    * @return string JSON string of what got deleted
    */
    public function delete(string $endPoint): \JsonSerializable
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "DELETE");
    }
    /**
    * Updates/Modifies a ProcessedComponent with the arguments given.
    * @param string $endPoint API URI
    * @param ProcessedComponent $content
    * @return string JSON API Response
    */
    public function put(string $endPoint, ProcessedComponent &$content)
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "PUT", json_encode($content));
    }
    /**
    * Turns the given endPoint string into a usable
    * @param string $endPoint
    * @return string Fixed enpoint string
    */
    private static function parseEndPoint(string $endPoint)
    {
        $endPoint = trim($endPoint, '/');
        $endPointArray = explode('/', $endPoint);
        if ($endPointArray[0] == "api") {
            return $endPoint;
        }
        array_unshift($endPointArray, "api");

        return implode('/', array_filter($endPointArray));
    }
    /**
    * Sends a HTTP request to the RESTful API and returns the result as a JSON string
    *
    *   @param string $endPoint    The URI that the function should use.
    *   @param string $method      The HTTP method that should be used, valid ones are: POST, GET, DELETE, PUT.
    *   @param string $content (optional) A JSON string containing all additional data that doesn't belong in $endPoint.
    *   @param bool $https (optional) Whether the the API call should use HTTPS or not(HTTP).
    *   @return string             The response from the API
    */
    private function sendRequest(string $endPoint, string $method, string $content = "", bool $https = false): string
    {
        $options = array(
            'http' => array(
                'header'  => array(
                    'Content-Type: application/json',
                    'Authorization: Basic '. $this->accessQuery,
                    'Content-Length: ' . strlen($content),
                ),
                'user_agent' => 'IP1sms/indev',
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
