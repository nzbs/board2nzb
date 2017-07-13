<?php

namespace Board2NZB;

class TownProvider {

  protected static $securitytoken = null;
	
	public function search($searchstring) {
		// Retrieve the necessary security token
    $securitytoken = $this->townLoginGetSecurityToken();
    Logger::log("Town security token: " . json_encode($securitytoken));

    // Do search
		$url = TOWN_BASE_URL . 'ajaxlivesearch.php?do=lsa';
    $curl_return = VBulletin::ajaxsearch($url, $searchstring, $securitytoken, TOWN_BASE_URL, 'allforum');
    //Logger::log("Search Result Data: " . $curl_return);

    // Prepare results
		preg_match_all('/<!\[CDATA\[(.*)\]\]>/s', $curl_return, $searchResult);
    //Logger::log("Search Result: " . json_encode($searchResult));

		$searchResults = array();
		if(isset($searchResult[1][0])) {
			$searchResult = $searchResult[1][0];
			if($dom = str_get_html($searchResult)) {
				$ret = $dom->find('tr[onmouseover]');
				foreach($ret as $key => $tr) {
				  $link = $tr->find('td',0)->find('a',1);
				  $category = $tr->find('td',1)->find('a',0);

          // TODO map category-title to newznab-category

				  if(isset($link) && isset($category))
				    $searchResults[] = new SearchResult($link->title, $link->href, $category->title, $category->href);
				}
			}
		}
		
		return $searchResults;
	}
	
	private function townLoginGetSecurityToken() {
    if (self::$securitytoken === null) {
      // Check if user is still logged in
      $curl_return = CURL::get(TOWN_BASE_URL, TOWN_BASE_URL);
      if (preg_match_all("/Sie sind nicht angemeldet oder Sie haben keine Rechte diese Seite zu betreten./", $curl_return)) {

        // Login
        $url = TOWN_BASE_URL . "login.php?do=login";
        $referer = TOWN_BASE_URL;
        $curl_return = VBulletin::login(USERNAME, PASSWORD, $url, $referer);
      }

      // Extract security token
      preg_match_all('/SECURITYTOKEN = "([^"]*)";/', $curl_return, $securitytoken);
      $securitytoken = $securitytoken[1][0];

      // Check for must-read-threads
      $url = TOWN_BASE_URL;
      $this->check_for_mustread_threads($url);

      self::$securitytoken = $securitytoken;
    } else {
      $securitytoken = self::$securitytoken;
    }

    return $securitytoken;
	}

  public function check_for_mustread_threads($url)
  {
    $curl_return = CURL::get($url, $url);
    if (preg_match_all('/<font color="green">Bitte klicke&nbsp>>> <\/font> <a href="([^"]*)">/s', $curl_return, $searchResult)) {
      $url = $searchResult[1][0];
      $curl_return = CURL::get($url, $url);
    }
  }

  public function getNZBInformation($threadURL)
  {
    // Retrieve the necessary security token
    $securitytoken = $this->townLoginGetSecurityToken();

    // 3. Load thread
    $curl_return = CURL::get($threadURL, TOWN_BASE_URL);

    // Check if the hidden contents are already unlocked
    if (preg_match_all('/unlocked.gif/U', $curl_return, $searchResult)) {
      return $this->extractNzbInformation($curl_return);
    } else {
      // 4. Thank on first post
      if (preg_match_all('/!thanks_do\((.*)\);/U', $curl_return, $searchResult)) {
        $postid = $searchResult[1][0];

        $url = TOWN_BASE_URL . 'ajax.php';
        $curl_return = VBulletin::thanks($url, $postid, $securitytoken, $threadURL);

        return $this->extractNzbInformation($curl_return);
      }
    }
    return null;
  }

  /**
   * @param curl_return
   */
  private function extractNzbInformation($curl_return)
  {
    $nzbInfo = new NzbInformation("", "");
    // Extract URL from response
    if (preg_match_all('/attachments\/(.*).nzb/U', $curl_return, $nzbLink)) {
      $nzbInfo->link = TOWN_BASE_URL . $nzbLink[0][0];
    }
    // Extract password
    if (preg_match_all("/<pre class=\"alt2\"[^>]*>(.*)<\/div>/sU", $curl_return, $nzbPassword)) {

      //FIXME: Dirty workaround because the regex is not working properly and there is still a /r/n in the password
      $nzbPassword = html_entity_decode($nzbPassword[1][0]);
      $nzbPassword = str_replace("</pre>\r\n", "", $nzbPassword);

      $nzbInfo->password = trim($nzbPassword);
      Logger::log("Password: " . json_encode($nzbPassword));
    }
    return $nzbInfo;
  }

  public function getNZBFile($nzblink)
  {
    return CURL::get($nzblink, TOWN_BASE_URL);
  }
}