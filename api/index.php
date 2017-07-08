<?php

namespace Board2NZB;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

Logger::log("New request: " . json_encode($_GET));

// Output is either json or xml.
$outputXML = (isset($_GET['o']) && ($_GET['o'] == 'json' || $_GET['o'] == 'JSON') ? false : true);

// Read apikey
isset($_GET['apikey']) ? $apikey = $_GET['apikey'] : $apikey = '';

// API functions.
if (isset($_GET['t'])) {
  switch ($_GET['t']) {
    case 'd':
    case 'details':
      // Get individual NZB details.
      Authorization::checkAuthorization($apikey);
      echo (new NZBDetails())->get($outputXML);
      break;

    case 'g':
    case 'get':
      // Get NZB
      Authorization::checkAuthorization($apikey);

      $id = '';
      if (!isset($_GET['id'])) {
        Misc::showApiError(200, 'Missing parameter (id is required for downloading an NZB)');
      } else {
        $id = $_GET['id'];
      }

      echo (new NZBDownload())->get($id);
      break;
    case 's':
    case 'search':
      // Search releases
      Authorization::checkAuthorization($apikey);

      $q = '';
      if (!isset($_GET['q'])) {
        Misc::showApiError(200, 'Missing parameter (q is required for searching)');
      } else {
        $q = $_GET['q'];
      }

      echo (new Search())->do($outputXML, $q, $apikey);
      break;
    case 'c':
    case 'caps':
      // Capabilities request.
      //Authorization::checkAuthorization($apikey); // No authorization required
      echo (new Capabilities())->get($outputXML);
      break;
    case 'tv':
    case 'tvsearch':
      // Search for TV
      Authorization::checkAuthorization($apikey);

      $tvdbid = '';
      !isset($_GET['tvdbid']) ?
          Misc::showApiError(200, 'Missing parameter (tvdbid is required for tv-search)') :
          $tvdbid = $_GET['tvdbid'];

      $season = '';
      !isset($_GET['season']) ?
          Misc::showApiError(200, 'Missing parameter (season is required for tv-search)') :
          $season = $_GET['season'];

      $ep = '';
      !isset($_GET['ep']) ?
          Misc::showApiError(200, 'Missing parameter (ep is required for tv-search)') :
          $ep = $_GET['ep'];

      echo (new SearchTV())->do($outputXML, $tvdbid, $season, $ep);
      die();
      break;
    case 'm':
    case 'movie':
      // Search for movie
      Authorization::checkAuthorization($apikey);
      echo (new SearchMovie())->do($outputXML);
      break;
    case 'gn':
    case 'n':
    case 'nfo':
    case 'info':
      // Get an NFO file for an individual release.
      Authorization::checkAuthorization($apikey);
      echo (new Nfo())->get();
      break;
    case 'r':
    case 'register':
      // Register request.
      //Authorization::checkAuthorization($apikey); // No authorization required
      echo (new Registration($outputXML))->do($outputXML);
      break;
    default:
      Misc::showApiError(202, 'No such function (' . $_GET['t'] . ')');
  }
} else {
  Misc::showApiError(200, 'Missing parameter (t)');
}
