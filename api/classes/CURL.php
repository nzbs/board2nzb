<?php
namespace Board2NZB;

class CURL
{

  public static function post($url, $postfields, $referer)
  {
    Logger::log("CURL Post: " . $url);
    $curl = self::prepare($url, $referer);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

    $curl_return = curl_exec($curl);
    curl_close($curl);
    return $curl_return;
  }

  private static function prepare($url, $referer)
  {
    $cookieFile = sys_get_temp_dir() . '/board2nzb-cookies.tmp';
    Logger::log("Cookie-File: " . $cookieFile);

    $httpheaders = array();
    $httpheaders[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $httpheaders[] = "Accept-Language: en-us,en;q=0.5";
    $httpheaders[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";

    // do login and fetch return (with header)
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_REFERER, $referer);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
    //curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_USERAGENT, 'User-Agent: Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheaders);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);

    return $curl;
  }

  public static function get($url, $referer)
  {
    Logger::log("CURL Get: " . $url);
    $curl = self::prepare($url, $referer);

    $curl_return = curl_exec($curl);
    curl_close($curl);
    return $curl_return;
  }

}