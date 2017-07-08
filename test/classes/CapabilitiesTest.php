<?php

namespace Board2NZB;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config.php';

use PHPUnit\Framework\TestCase;

class CapabilitiesTest extends TestCase
{
  /**
   * @runInSeparateProcess
   */
  public function testGetXML()
  {
    $outputXML = true;

    $caps = new Capabilities();
    $xml = $caps->get($outputXML);

    self::assertNotEmpty($xml);
    $dom = str_get_html($xml);
    self::assertNotFalse($dom);

    // Check registration
    $registrationAvailableElement = $dom->find('registration[available=no]');
    self::assertNotEmpty($registrationAvailableElement);

    $registrationOpenElement = $dom->find('registration[open=no]');
    self::assertNotEmpty($registrationOpenElement);

    // Check search
    $searchAvailableElement = $dom->find('searching search[available=yes]');
    self::assertNotEmpty($searchAvailableElement);

    $searchSupportedParamsElement = $dom->find('searching search[supportedParams=q,group]');
    self::assertNotEmpty($searchSupportedParamsElement);

    // Check tv search
    $tvSearchAvailableElement = $dom->find('searching tv-search[available=yes]');
    self::assertNotEmpty($tvSearchAvailableElement);

    $tvSearchSupportedParamsElement = $dom->find('searching tv-search[supportedParams=q,rid,tvdbid,season,ep]');
    self::assertNotEmpty($tvSearchSupportedParamsElement);

    // Check movie search
    $movieSearchAvailableElement = $dom->find('searching movie-search[available=no]');
    self::assertNotEmpty($movieSearchAvailableElement);

    $movieSearchSupportedParamsElement = $dom->find('searching movie-search[supportedParams=q,imdbid,genre]');
    self::assertNotEmpty($movieSearchSupportedParamsElement);

    // Check audio search
    $audioSearchAvailableElement = $dom->find('searching audio-search[available=no]');
    self::assertNotEmpty($audioSearchAvailableElement);

    $audioSearchSupportedParamsElement = $dom->find('searching audio-search[supportedParams=q,album,artist,label,year,genre]');
    self::assertNotEmpty($audioSearchSupportedParamsElement);
  }

  /**
   * @runInSeparateProcess
   */
  public function testGetJSON()
  {
    $outputXML = false;

    $caps = new Capabilities();
    $json = $caps->get($outputXML);
    $c = json_decode($json, true);

    // Check registration
    self::assertEquals($c["registration"]["available"], "no");
    self::assertEquals($c["registration"]["open"], "no");

    // Check search
    self::assertEquals($c["searching"]["search"]["available"], "yes");
    self::assertEquals($c["searching"]["search"]["supportedParams"], "q,group");

    // Check tv search
    self::assertEquals($c["searching"]["tv-search"]["available"], "yes");
    self::assertEquals($c["searching"]["tv-search"]["supportedParams"], "q,rid,tvdbid,season,ep");

    // Check movie search
    self::assertEquals($c["searching"]["movie-search"]["available"], "no");
    self::assertEquals($c["searching"]["movie-search"]["supportedParams"], "q,imdbid,genre");

    // Check audio search
    self::assertEquals($c["searching"]["audio-search"]["available"], "no");
    self::assertEquals($c["searching"]["audio-search"]["supportedParams"], "q,album,artist,label,year,genre");
  }
}
