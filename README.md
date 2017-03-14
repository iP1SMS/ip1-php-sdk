# IP1 RESTClient
A PHP SDK for IP1's SMS services.

** Note: This package is in a beta stage and it's not recommended for use in production **

## Getting Started
### Installing
Install using Composer.
```json
{
  "require": {
    "ip1sms/phprestclient": "*"
  }
}
```
### Getting API Credentials
Create a free test-account at:

[app.ip1sms.com](https://app.ip1sms.com/account/signup?l=en)

Then log in at this [link](https://app.ip1sms.com/account/) using the credentials sent to the phone number provided via SMS.
Once logged in click on ``Settings`` and then ``SMS Gateway API`` and you will be presented in the left panel with an account ID. The API Key will be sent to the phone number provided on registration when the ``Send API Key`` is clicked.

### Basic Usage
###### Sending a text message.
```php
<?php
use IP1\RESTClient\SMS\OutGoingSMS;
use IP1\RESTClient\Core\Communicator;

$com = new Communicator("{account-id}", "{apiKey}");
$sms = new OutGoingSMS("{nameOrNumber}", "IP1 SMS is the best!");
$sms->addNumber("{aPhoneNumber}");
$com->add($sms);
```
###### Adding a contact and then editing it.
```php
<?php
use IP1\RESTClient\Recipient\Contact;
use IP1\RESTClient\Recipient\ProcessedContact;
use IP1\RESTClient\Core\Communicator;

$com = new Communicator("{accountID}", "{apiKey}");
$contact = new Contact("Jack", "{aPhoneNumber}");
$contact = $com->add($contact);

$contact->setEmail("jack@example.org");
$com->edit($contact);
```


## Authors
 * ** Hannes Kindströmmer ** - _Initial work_

## License
 TODO: Add license.

## Contributing
Please file issues under [SELECT PUBLIC GIT HOSTING], or submit a pull request if you'd like to directly contribute.
Note that this project uses an extended version of PSR2 which adds some commenting rules from Squiz in order for PHPDoc to work correctly.

### Running tests
Tests are run with phpunit. Run ``./vendor/bin/phpunit`` to run tests.
