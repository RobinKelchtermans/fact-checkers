<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
// An example of using php-webdriver.
// Do not forget to run composer install before and also have Selenium server started and listening on port 4444.
namespace Facebook\WebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;

$before = microtime(true);

require_once('vendor/autoload.php');


// start Chrome with 5 second timeout
$host = 'http://localhost:4444/wd/hub'; // this is the default
$options = new ChromeOptions();
$options->addArguments(array(
    '--headless',
));
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($host, $caps, 5000);


/*
    De Morgen
*/
$driver->get('https://www.demorgen.be/politiek/de-dag-dat-anuna-de-wever-besloot-te-gaan-betogen-is-de-dag-dat-bart-de-wever-wir-schaffen-das-omarmde-b1014e92/');


// adding cookie
// $driver->manage()->deleteAllCookies();
// $cookie = new Cookie('cookieConsent', 'true');
// $driver->manage()->addCookie($cookie);
// $cookie = new Cookie('cookieConsentDM', 'true');
// $driver->manage()->addCookie($cookie);
// $cookies = $driver->manage()->getCookies();
// print_r($cookies);


// click the link 'About'
$link = $driver->findElement(WebDriverBy::className('fjs-set-consent'));
$link->click();


echo $driver->getTitle() . "\n";
echo "The current URI is '" . $driver->getCurrentURL() . "'\n";
echo "\n";
$article = $driver->findElement(WebDriverBy::className('article__wrapper'));
var_dump($article->getText());

// $driver->executeScript('return window.stop;');
// $driver->findElement(WebDriverBy::tagName("body"))->sendKeys("Keys.ESCAPE");
// $driver->wait();
// $driver->manage()->timeouts()->pageLoadTimeout(2);
// $driver->get('https://www.google.com/');


// close the browser
$driver->quit();


$after = microtime(true);
echo ($after-$before) . " time needed\n";
