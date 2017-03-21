<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Core;

use IP1\RESTClient\Recipient\RecipientFactory;
use IP1\RESTClient\Recipient\ProcessedBlacklistEntry;
use IP1\RESTClient\Core\ProcessedComponentInterface;
use IP1\RESTClient\Core\UpdatableComponentInterface;
use IP1\RESTClient\Core\ProcessableComponentInterface;

/**
* Handles request to the API and converts the responses into the data classes.
* For the available endpoints check out link.
*/
class Communicator
{
    /**
    * The accountToken used for the first argument in HTTP Basic Auth.
    * @var string $accountToken
    */
    private $accountToken;
    /**
    * The apiToken used for the second argument in HTTP Basic Auth.
    * @var string $apiToken
    */
    private $apiToken;
    /**
    * An array of \Httpful\Response that returned HTTP code above or equal to 400.
    * @var array \Httpful\Response
    */
    public $errorResponses = [];
    const DOMAIN = "api.ip1sms.com";
    /**
    * Communicator constructor
    * @param string $accountToken Account ID. Provided by IP1.
    * @param string $apiToken     API Key.
    */
    public function __construct(string $accountToken, string $apiToken)
    {
        $this->accountToken = $accountToken;
        $this->apiToken = $apiToken;
    }
    /**
    * Adds the param to the API and returns the response as the corresponding object.
    * @param ProcessableComponentInterface $component A Contact, Group, Membership or OutGoingSMS.
    * @return ProcessedComponentInterface ProcessedContact, ProcessedGroup, PrcessedMembership or a ClassValidatinArray
    *           filled with ProcessedOutGoingSMS.
    * @throws \InvalidArgumentException When param isn't any of the classes listed in param args.
    */
    public function add(ProcessableComponentInterface $component): ProcessedComponentInterface
    {
        switch (get_class($component)) {
            case "IP1\RESTClient\Recipient\Contact":
                $response = $this->sendRequest("api/contacts", "POST", json_encode($component));
                return RecipientFactory::createProcessedContactFromJSON($response);

            case "IP1\RESTClient\Recipient\Group":
                $response = $this->sendRequest("api/groups", "POST", json_encode($component));
                return RecipientFactory::createProcessedGroupFromJSON($response);

            case "IP1\RESTClient\Recipient\Membership":
                $response = $this->sendRequest("api/memberships", "POST", json_encode($component));
                return RecipientFactory::createProcessedMembershipFromJSON($response);

            case "IP1\RESTClient\SMS\OutGoingSMS":
                $response = $this->sendRequest("api/sms/send", "POST", json_encode($component));
                return RecipientFactory::createProcessedOutGoingSMSFromJSONArray($response);
            case "IP1\RESTClient\Recipient\BlacklistEntry":
                $response = $this->sendRequest("api/blacklist", "POST", json_encode($component));
                $stdResponse = json_decode($response);
                $created = new \DateTime($stdResponse->Created);
                return new ProcessedBlacklistEntry($stdResponse->Phone, $stdResponse->ID, $created);
            default:
                throw new \InvalidArgumentException("Given JsonSerializable not supported.");
        }
    }
    /**
    * Removes the param to the API and returns the response as the corresponding object.
    * @param ProcessedComponentInterface $component A Contact, Group, Membership.
    * @return ProcessedComponentInterface ProcessedContact, ProcessedGroup, PrcessedMembership or a ClassValidatinArray
    *           filled with ProcessedOutGoingSMS.
    * @throws \InvalidArgumentException When param isn't any of the classes listed in param args.
    */
    public function remove(ProcessedComponentInterface $component): ProcessedComponentInterface
    {
        switch (get_class($component)) {
            case "IP1\RESTClient\Recipient\ProcessedContact":
                $response = $this->sendRequest("api/contacts/".$component->getID(), "DELETE");
                return RecipientFactory::createProcessedContactFromJSON($response);

            case "IP1\RESTClient\Recipient\ProcessedGroup":
                $response = $this->sendRequest("api/groups/".$component->getID(), "DELETE");
                return RecipientFactory::createProcessedGroupFromJSON($response);

            case "IP1\RESTClient\Recipient\ProcessedMembership":
                $response = $this->sendRequest("api/memberships/".$component->getID(), "DELETE");
                return RecipientFactory::createProcessedMembershipFromJSON($response);

            case "IP1\RESTClient\Recipient\ProcessedBlacklistEntry":
                $response = $this->sendRequest("api/blacklist/".$component->getID(), "DELETE");
                $stdResponse = json_decode($response);
                $created = new \DateTime($stdResponse->Created);
                return new ProcessedBlacklistEntry($stdResponse->Phone, $stdResponse->ID, $created);

            default:
                throw new \InvalidArgumentException("Given JsonSerializable not supported.");
        }
    }
    /**
    * Edits the param to the API and returns the response as the corresponding object.
    * @param UpdatableComponentInterface $component A Contact, Group, Membership.
    * @return UpdatableComponentInterface ProcessedContact, ProcessedGroup or PrcessedMembership.
    * @throws \InvalidArgumentException When param isn't any of the classes listed in param args.
    */
    public function edit(UpdatableComponentInterface $component): UpdatableComponentInterface
    {
        switch (get_class($component)) {
            case "IP1\RESTClient\Recipient\ProcessedContact":
                $response = $this->sendRequest(
                    "api/contacts/".$component->getID(),
                    "PUT",
                    json_encode($component)
                );
                return RecipientFactory::createProcessedContactFromJSON($response);

            case "IP1\RESTClient\Recipient\ProcessedGroup":
                $response = $this->sendRequest(
                    "api/groups/".$component->getID(),
                    "PUT",
                    json_encode($component)
                );
                return RecipientFactory::createProcessedGroupFromJSON($response);
            default:
                throw new \InvalidArgumentException("Given JsonSerializable not supported.");
        }
    }

    /**
    * Fetches a ProcessedComponentInterface(s) from the given URI.
    * @param string $endPoint API URI.
    * @return string JSON API Response.
    */
    public function get(string $endPoint)
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "GET");
    }
    /**
    * Adds the content object to the endpoint and returns a processed version of given object.
    * @param string            $endPoint API URI.
    * @param \JsonSerializable $content  The ProcessableComponentInterface that is to be posted to the API.
    * @return string JSON API Response.
    */
    public function post(string $endPoint, \JsonSerializable $content): string
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "POST", json_encode($content));
    }
    /**
    * Deletes the object at the given endpoint
    * @param string $endPoint API URI.
    * @return string JSON string of what got deleted.
    */
    public function delete(string $endPoint): string
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "DELETE");
    }
    /**
    * Replaces a ProcessedComponentInterface with the arguments given.
    * @param string            $endPoint API URI.
    * @param \JsonSerializable $content  The JsonSerializable that is to be PUT to the API.
    * @return string JSON API Response.
    */
    public function put(string $endPoint, \JsonSerializable $content): string
    {
        $parsedEndPoint = self::parseEndPoint($endPoint);
        return $this->sendRequest($parsedEndPoint, "PUT", json_encode($content));
    }
    /**
    * Turns the given endPoint string into a usable.
    * @param string $endPoint API URI.
    * @return string Fixed endpoint string.
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
    * Sends a HTTP request to the RESTful API and returns the result as a JSON string.
    *
    *   @param string  $endPoint The URI that the function should use.
    *   @param string  $method   The HTTP method that should be used, valid ones are:
    *                                   METH_POST, METH_GET, METH_DELETE and METH_PUT.
    *   @param string  $content  A JSON string containing all additional data that can not be provided by $endPoint.
    *   @param boolean $https    Whether the the API call should use HTTPS or not(HTTP).
    *   @return string             The response from the API.
    */
    private function sendRequest(string $endPoint, string $method, string $content = "", bool $https = false): string
    {
        $url = ($https ? "https://" : "http://") . self::DOMAIN . "/" .$endPoint;
        $request = \Httpful\Request::init($method, 'application/json');
        $request->basicAuth($this->accountToken, $this->apiToken)
                ->addHeader('User-Agent', 'iP1sms/indev')
                ->expectsJson()
                ->Uri($url)
                ->body($content, 'application/json')
                ->neverSerialize();

        $response = $request->send();

        if ($response->hasErrors()) {
            $this->errorResponses[] = $response;
        }
        return $response->__toString();
    }
}
