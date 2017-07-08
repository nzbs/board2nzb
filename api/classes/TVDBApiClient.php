<?php

namespace Board2NZB;

class TVDBApiClient {
	public function getSeriesTitle($tvdbid) {
    $client = new \Adrenth\Thetvdb\Client();
    $client->setLanguage('en');

    // Obtain a token
    $token = $client->authentication()->login(TVDB_API_KEY, TVDB_USERNAME, TVDB_USERKEY);
    $client->setToken($token);

    $serie = $client->series()->get($tvdbid);
    Logger::log("Series data: " . $serie->getSeriesName());

    return $serie->getSeriesName();
	}
}
