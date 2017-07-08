<?php

namespace Board2NZB;

/*
 * General util functions.
 * Class Misc
 */
class Misc
{
  /**
   *  Regex for detecting multi-platform path. Use it where needed so it can be updated in one location as required characters get added.
   */
  const PATH_REGEX = '(?P<drive>[A-Za-z]:|)(?P<path>[\\/\w .-]+|)';

  /**
   * Display error/error code.
   * @param int    $errorCode
   * @param string $errorText
   */
  public static function showApiError($errorCode = 900, $errorText = '')
  {
    if ($errorText === '') {
      switch ($errorCode) {
        case 100:
          $errorText = 'Incorrect user credentials';
          break;
        case 101:
          $errorText = 'Account suspended';
          break;
        case 102:
          $errorText = 'Insufficient privileges/not authorized';
          break;
        case 103:
          $errorText = 'Registration denied';
          break;
        case 104:
          $errorText = 'Registrations are closed';
          break;
        case 105:
          $errorText = 'Invalid registration (Email Address Taken)';
          break;
        case 106:
          $errorText = 'Invalid registration (Email Address Bad Format)';
          break;
        case 107:
          $errorText = 'Registration Failed (Data error)';
          break;
        case 200:
          $errorText = 'Missing parameter';
          break;
        case 201:
          $errorText = 'Incorrect parameter';
          break;
        case 202:
          $errorText = 'No such function';
          break;
        case 203:
          $errorText = 'Function not available';
          break;
        case 300:
          $errorText = 'No such item';
          break;
        case 500:
          $errorText = 'Request limit reached';
          break;
        case 501:
          $errorText = 'Download limit reached';
          break;
        default:
          $errorText = 'Unknown error';
          break;
      }
    }

    $response =
        "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
        '<error code="' . $errorCode . '" description="' . $errorText . "\"/>\n";
    header('Content-type: text/xml');
    header('Content-Length: ' . strlen($response) );
    header('X-nZEDb: API ERROR [' . $errorCode . '] ' . $errorText);

    exit($response);
  }

  public static function getServerroot() {
    return WEBPATH;
  }
}
