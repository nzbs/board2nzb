<?php

namespace Board2NZB;

class SearchTV
{
  function doSearch($outputXML, $tvdbid, $season, $ep, $apikey)
  {
    Logger::log("New tv search: " . json_encode($_GET));
    // "apikey":"1234","tvdbid":"274431","season":"2","maxage":"1200",
    //"cat":"5000,5020,5030,5040,5050,5060,5070,5080","limit":"100",
    //"t":"tvsearch","offset":"0","ep":"21"

    //Retrieve series title from thetvdb
    $tvdb = new TVDBApiClient();
    $seriesTitle = $tvdb->getSeriesTitle($tvdbid);
    $q = $seriesTitle . " S" . ($season < 10 ? "0" : "") . $season . "E" . ($ep < 10 ? "0" : "") . $ep;

    return (new Search())->doSearch($outputXML, $q, $apikey);
  }
}
