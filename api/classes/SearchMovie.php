<?php

namespace Board2NZB;

class SearchMovie
{
  function do($outputXML)
  {
    // TODO not yet implemented

    Misc::showApiError(203);

// 	$api->verifyEmptyParameter('q');
// 	$api->verifyEmptyParameter('imdbid');
// 	$maxAge = $api->maxAge();
// 	$page->users->addApiRequest($uid, $_SERVER['REQUEST_URI']);

// 	$imdbId = (isset($_GET['imdbid']) ? $_GET['imdbid'] : '-1');

// 	$relData = $releases->searchbyImdbId(
// 			$imdbId,
// 			$offset,
// 			$api->limit(),
// 			(isset($_GET['q']) ? $_GET['q'] : ''),
// 			$api->categoryID(),
// 			$maxAge,
// 			$minSize
// 			);

// 	$api->addCoverURL($relData,
// 			function($release) {
// 				return Misc::getCoverURL(['type' => 'movies', 'id' => $release['imdbid']]);
// 			}
// 			);

// 	$api->addLanguage($relData);
// 	$api->printOutput($relData, $outputXML, $page, $offset);
  }
}
