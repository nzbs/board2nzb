<?php

namespace Board2NZB;

use Smarty;

class Search
{
  /**
   * @param bool $outputXML
   * @param string $q
   * @param string $apikey
   * @return string Search results
   * @return string Search results
   */
  function doSearch($outputXML = true, $q, $apikey)
  {
    Logger::log("New search: " . json_encode($_GET));

    //Decode categories
//    $categoryID[] = -1;
//    if (isset($_GET['cat'])) {
//      $categoryIDs = urldecode($_GET['cat']);
//      $categoryID = explode(',', $categoryIDs);
//    }

    $relData = array();
    if (!empty($q)) {
      $town = new TownProvider();
      $relData = $town->search($q);
    }

    Logger::log("Returning " . count($relData) . " search results");

    if ($outputXML) {
      return $this->returnXML($relData, $apikey);
    } else {
      return $this->returnJSON($relData, $apikey);
    }
  }

  /**
   * @param $relData
   */
  public function returnXML($relData, $apikey)
  {
    $smarty = new Smarty();
    $smarty->assign('serverroot', Misc::getServerroot());
    $smarty->assign('queryString', isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "");
    $smarty->assign('releases', $relData);
    $smarty->assign('extended', 0);
    $smarty->assign('apikey', $apikey);
    $response = trim($smarty->fetch(__DIR__ . '/../templates/apiresult.tpl'));

    header('Content-type: text/xml');
    header('Content-Length: ' . strlen($response));
    return $response;
  }

  /**
   * @param $relData
   */
  public function returnJSON($relData, $apikey)
  {
    $response = json_encode($this->buildJSONStructure($relData, $apikey));
    header('Content-type: application/json');
    header('Content-Length: ' . strlen($response));
    return $response;
  }

  /**
   * @param $relData
   * @return array
   */
  public function buildJSONStructure($relData, $apikey)
  {
// Transform search results to the correct json structure
    $releases = $this->prepareJSONReleases($relData, $apikey);

    // Prepare response
    $response = [
        "@attributes" => [
            "version" => "2.0"
        ],
        "channel" => [
            "title" => "Board2NZB",
            "description" => "Board2NZB Index Feed",
            "link" => Misc::getServerroot(),
            "language" => "en-gb",
            "webMaster" => "noreply@example.com (Anonymous)",
            "category" => [],
            "image" => [
                "url" => Misc::getServerroot() . "img/banner.jpg",
                "title" => "Board2NZB",
                "link" => Misc::getServerroot(),
                "description" => "Visit Board2NZB - API TV Index"
            ],
            "response" => [
                "@attributes" => [
                    "offset" => "0",
                    "total" => count($relData)
                ]
            ],
            "item" => $releases,
        ]
    ];
    return $response;
  }

  /**
   * @param $relData
   * @return array
   */
  public function prepareJSONReleases($relData, $apikey)
  {
    $releases = array();
    foreach ($relData as $release) {

      $attributes = $this->prepareJSONAttributes($release);


      // Prepare release structure
      $releases[] = array(
          "title" => $release->title,
          "guid" => $release->link,
          "link" => Misc::getServerroot() . "api?t=get&id=" . urlencode($release->link) . "&apikey=" . $apikey,
          "comments" => "",
          "pubdate" => "",
          "category" => $release->category,
          "description" => $release->title,
          "enclosure" => array(
              "@attributes" => array(
                  "url" => Misc::getServerroot() . "api?t=get&id=" . urlencode($release->link) . "&apikey=" . $apikey,
                  "length" => "",
                  "type" => "application/x-nzb"
              )
          ),
          "@attributes" => $attributes
      );
    }
    return $releases;
  }

  /**
   * Add news-categories and the release-link to the attributes
   * @param $release
   * @return  $attributes
   */
  public
  function prepareJSONAttributes($release)
  {
    $categories = $release->category_ids;
    $attributes = array();
    foreach ($categories as $cat) {
      $attributes[] = array(
          "@attributes" => array(
              "name" => "category",
              "value" => $cat
          )
      );
    }
    $attributes[] = array(
        "@attributes" => array(
            "name" => "guid",
            "value" => $release->link
        )
    );

    return $attributes;
  }
}
