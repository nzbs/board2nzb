<?php

namespace classes;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config.php';

use Board2NZB\Search;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{

  /**
   * @runInSeparateProcess
   */
  public function testSearchXML()
  {
    $outputXML = true;
    $q = 'german';
    $apikey = APIKEY;

    $search = new Search();
    $xml = $search->doSearch($outputXML, $q, $apikey);

    self::assertNotEmpty($xml);
    $dom = str_get_html($xml);
    self::assertNotFalse($dom);

    // Title
    $title = $dom->find('channel title', 0);
    self::assertEquals("Board2NZB", $title->innertext);

    // Description
    $description = $dom->find('channel description', 0);
    self::assertEquals("Board2NZB API Results", $description->innertext);

    // newsnab:response
    $newznab = $dom->find('channel newznab:response', 0);
    self::assertEquals("newznab:response", $newznab->tag);

    // Items
    $items = $dom->find('channel newznab:response item');
    self::assertTrue(count($items) > 0);

    $item = $items[0];
    // Item title
    $title = $item->find('title', 0);
    self::assertNotEmpty($title->innertext);
    self::assertTrue(is_string($title->innertext));

    // Item link
    $link = $item->find('link', 0);
//    self::assertNotEmpty($link->innertext);
//    self::assertTrue(is_string($link->innertext));
//
//    self::assertTrue(preg_match("$" . WEBPATH . "$", $link) > 0);
//    self::assertTrue(preg_match("/t=get/", $link->innertext) > 0);
//    self::assertTrue(preg_match("/apikey=" . APIKEY . "/", $link->innertext) >0);

    // Item category
    $category = $item->find('category', 0);
    self::assertNotEmpty($category->innertext);
    self::assertTrue(is_string($category->innertext));

    // Item enclosure url
    $enclosure = $item->find('enclosure', 0);
    $url = $enclosure->url;
    self::assertNotEmpty($url);
    self::assertTrue(is_string($url));

    self::assertTrue(preg_match("$" . WEBPATH . "$", $url) > 0);
    self::assertTrue(preg_match("/t=get/", $url) > 0);
    self::assertTrue(preg_match("/apikey=" . APIKEY . "/", $url) > 0);

  }

  /**
   * @runInSeparateProcess
   */
  public function testJSON()
  {
    $outputXML = false;
    $q = 'german';
    $apikey = APIKEY;

    $search = new Search();
    $json = $search->doSearch($outputXML, $q, $apikey);
    $results = json_decode($json, true);

    self::assertTrue(is_array($results));

    // Title
    self::assertNotEmpty($results["channel"]["title"]);

    // Description
    self::assertNotEmpty($results["channel"]["description"]);

    // Items
    $items = $results["channel"]["item"];
    self::assertTrue(count($items) > 0);

    $item = $items[0];
    // Item title
    self::assertNotEmpty($item["title"]);

    // Item link
    self::assertNotEmpty($item["link"]);

    self::assertTrue(preg_match("$" . WEBPATH . "$", $item["link"]) > 0);
    self::assertTrue(preg_match("/t=get/", $item["link"]) > 0);
    self::assertTrue(preg_match("/apikey=" . APIKEY . "/", $item["link"]) > 0);

    // Item category
    self::assertNotEmpty($item["category"]);

    // Item enclosure url
    $url = $item["enclosure"]["@attributes"]["url"];
    self::assertNotEmpty($url);

    self::assertTrue(preg_match("$" . WEBPATH . "$", $url) > 0);
    self::assertTrue(preg_match("/t=get/", $url) > 0);
    self::assertTrue(preg_match("/apikey=" . APIKEY . "/", $url) > 0);

  }
}
