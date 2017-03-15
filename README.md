# IP1 RESTClient
[![Build Status](https://travis-ci.org/iP1SMS/ip1-php-sdk.svg?branch=master)](https://travis-ci.org/iP1SMS/ip1-php-sdk)
[![Code Climate](https://codeclimate.com/github/iP1SMS/ip1-php-sdk/badges/gpa.svg)](https://codeclimate.com/github/iP1SMS/ip1-php-sdk)
[![Issue Count](https://codeclimate.com/github/iP1SMS/ip1-php-sdk/badges/issue_count.svg)](https://codeclimate.com/github/iP1SMS/ip1-php-sdk)

A PHP SDK for IP1's SMS services.

**Note: This package is in a beta stage and it's not recommended for use in production**

## Getting Started
### Installing
Install using Composer.
```json
{
  "require": {
    "ip1sms/ip1-php-sdk": "*"
  }
}
```
### Getting API Credentials

#### Paid Method
Visit the [IP1 SMS Shop](https://shop.ip1sms.com/#!/cart) and add an SMS balance or service of your choice and then proceed to checkout. Create an account at the  under Customer information. When done click ``Pay by Card`` and pay for chosen balance or service. An email has by this point been sent to you with login and API credentials. The ones you're interested in for using the API are Account ID and API Key.

#### Free Method
Create a free test-account at:
[app.ip1sms.com](https://app.ip1sms.com/account/signup)

Then log in at this [link](https://app.ip1sms.com/login/) using the credentials sent to the phone number provided via SMS. Once logged in click on Settings and then SMS Gateway API and you will be presented in the left panel with an account ID. The API Key will be sent to the phone number provided on registration when the Send API Key is clicked.

**Note:  You can verify your account and get €1 of credit if you verify your account by pressing** ``Verify yourself for test credits`` **In the middle left**.




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
 * **Hannes Kindströmmer** - _Initial work_

## License
 This project is licensed under the GNU LGPLv3 License -  see [LICENSE](LICENSE.md) file for details.

## Contributing
Please file issues under Github, or submit a pull request if you'd like to directly contribute.
Note that this project uses an extended version of PSR2 which adds some commenting rules from Squiz in order for PHPDoc to work correctly.

### Running tests
Tests are run with phpunit. Run ``./vendor/bin/phpunit`` to run tests.
