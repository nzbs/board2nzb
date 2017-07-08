<?php

namespace Board2NZB;

class Nfo
{
  function get()
  {
    // TODO not yet implemented

    Misc::showApiError(203);
// 	if (!isset($_GET['id'])) {
// 		Misc::showApiError(200, 'Missing parameter (id is required for retrieving an NFO)');
// 	}

// 	$page->users->addApiRequest($uid, $_SERVER['REQUEST_URI']);
// 	$rel = $releases->getByGuid($_GET["id"]);
// 	$data = $releases->getReleaseNfo($rel['id']);

// 	if ($rel !== false && !empty($rel)) {
// 		if ($data !== false) {
// 			if (isset($_GET['o']) && $_GET['o'] == 'file') {
// 				header("Content-type: application/octet-stream");
// 				header("Content-disposition: attachment; filename={$rel['searchname']}.nfo");
// 				exit($data['nfo']);
// 			} else {
// 				echo nl2br(Text::cp437toUTF($data['nfo']));
// 			}
// 		} else {
// 			Misc::showApiError(300, 'Release does not have an NFO file associated.');
// 		}
// 	} else {
// 		Misc::showApiError(300, 'Release does not exist.');
// 	}
  }
}
