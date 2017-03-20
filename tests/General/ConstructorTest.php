<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.1.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/

namespace IP1\RESTClient\Test\General;

use IP1\RESTClient\Recipient\Group;
use IP1\RESTClient\Recipient\Contact;
use IP1\RESTClient\Recipient\ProcessedContact;
use IP1\RESTClient\Recipient\Membership;
use IP1\RESTClient\Recipient\ProcessedMembership;
use IP1\RESTClient\Recipient\ProcessedGroup;
use IP1\RESTClient\SMS\ProcessedOutGoingSMS;
use PHPUnit\Framework\TestCase;
use \DateTime;

class ConstructorTest extends TestCase
{

    public function testRecipientConstructors()
    {
        $this->requireAll("src");
        $this->addToAssertionCount(1);
    }
    /**
     * Scan the api path, recursively including all PHP files
     *
     * @param string  $dir
     * @param int     $depth (optional)
     * @author mrashad10 at github.com
     * @author pwenzel at github.com
     * @link https://gist.github.com/mrashad10/807456e12a6811f644ca
     */
    protected function requireAll($dir, $depth = 0)
    {
        // require all php files
        $scan = glob("$dir" . DIRECTORY_SEPARATOR . "*");
        foreach ($scan as $path) {
            if (preg_match('/\.php$/', $path)) {
                require_once $path;
            } elseif (is_dir($path)) {
                $this->_require_all($path, $depth+1);
            }
        }
    }
}
