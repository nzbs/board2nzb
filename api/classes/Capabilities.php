<?php

namespace Board2NZB;

use Smarty;

class Capabilities
{
  public function get($outputXML)
  {
    Logger::log("Get caps: " . json_encode($_GET));

    //get supported newznab categories (currently has no influence at all)
    $cats = Category::getCategories();

    if ($outputXML) { //use apicaps.tpl if xml is requested
      return $this->returnXML($cats);
    } else { //otherwise construct array of capabilities and categories
      return $this->returnJSON($cats);
    }
  }


  /**
   * @param $cats
   */
  public function returnXML($cats)
  {
    $smarty = new Smarty();
    $smarty->assign('parentcatlist', $cats);
    $smarty->assign('serverroot', Misc::getServerroot());
    $response = $smarty->fetch(__DIR__ . '/../templates/apicaps.tpl');
    //$response = $smarty->fetch('templates/apicaps.tpl');
    header('Content-type: application/xml');
    header('Content-Length: ' . strlen($response));
    return $response;
  }

  /**
   * @param $cats
   */
  public function returnJSON($cats)
  {
    $caps = [
        'server' => [
            'appversion' => '1.0',
            'version' => '0.1',
            'title' => 'Board2NZB',
            'strapline' => 'Auto NBZ API',
            'email' => 'noreply@example.com',
            'url' => Misc::getServerroot(),
            'image' => Misc::getServerroot() . 'img/logo.png'
        ],
        'limits' => [
            'max' => 100,
            'default' => 100
        ],
        'registration' => [
            'available' => 'no',
            'open' => 'no'
        ],
        'searching' => [
            'search' => ['available' => 'yes', 'supportedParams' => 'q,group'],
            'tv-search' => ['available' => 'yes', 'supportedParams' => 'q,rid,tvdbid,season,ep'],
            'movie-search' => ['available' => 'no', 'supportedParams' => 'q,imdbid,genre'],
            'audio-search' => ['available' => 'no', 'supportedParams' => 'q,album,artist,label,year,genre']
        ]
    ];

    $caps['categories'] = $cats;
    //use json_encode
    $response = json_encode($caps);
    header('Content-type: application/json');
    header('Content-Length: ' . strlen($response));
    return $response;
  }
}
