<?php

namespace Board2NZB;

class Authorization
{
  function __construct()
  {
  }

  /**
   * Check if the user is authorized
   * @param string $apikey Key for accessing the api
   */
  public static function checkAuthorization($apikey = '')
  {
    if (empty($apikey)) {
      Misc::showApiError(200, 'Missing parameter (apikey)');
    } elseif ($apikey !== APIKEY) {
        Misc::showApiError(100, 'Incorrect user credentials (wrong API key)');
    }

    // Currently no diffentiation of users or api limits
    $uid = 1; //$res['id'];
    $catExclusions = []; //$page->users->getCategoryExclusion($uid);
    $maxRequests = 0; //$res['apirequests'];
  }
}
