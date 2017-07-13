<?php
namespace Board2NZB;

class VBulletin
{

  /** function login
   *
   *  With this function you can login a user into a vbulletin board.
   *
   * @param string $vb_username The vbulletin-account username
   * @param string $vb_password The vbulletin-account password
   * @param string $vb_url The url to the board
   */
  public static function login($vb_username, $vb_password, $vb_url, $referer)
  {

    $vb_username = trim($vb_username);
    $vb_password = trim($vb_password);
    $vb_password_md5 = md5($vb_password);

    $postfields = array(
        'vb_login_username' => $vb_username,
        'vb_login_password' => '',
        'cookieuser' => 1,
        's' => '',
        'do' => 'login',
        'vb_login_md5password' => $vb_password_md5,
        'vb_login_md5password_utf' => $vb_password_md5
    );

    $login_return = CURL::post($vb_url, $postfields, $referer);

    // Follow redirect to startpage
    // window.location = "http://www.town.ag/v2/?s=524998c8c7b41877d09a12f21005f46f&";
    preg_match_all('/window.location = "([^"]*)";/', $login_return, $link_to_startpage);
    $link_to_startpage = $link_to_startpage[1][0];
    Logger::log("Link to startpage: " . $link_to_startpage);

    return CURL::get($link_to_startpage, $referer);
  }

  public static function ajaxsearch($url, $searchstring, $securitytoken, $referer, $searchin = 'allforum')
  {
    $postfields = array(
        'do' => 'lsa',
        'keyword' => $searchstring,
        'lsatype' => 0,
        'searchin' => $searchin,
        'securitytoken' => $securitytoken,
        'sortby' => 'lastpost',
        'sorttype' => 'DESC',
        'withword' => 1
    );

    Logger::log("Postfelder: " . json_encode($postfields));

    return CURL::post($url, $postfields, $referer);
  }

  public static function thanks($url, $postid, $securitytoken, $referer)
  {
    $postfields = array(
        'do' => 'thanks',
        'postid' => $postid,
        's' => "",
        'securitytoken' => $securitytoken,
    );

    return CURL::post($url, $postfields, $referer);
  }
}
