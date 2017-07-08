<?php

namespace Board2NZB;

use DOMDocument;

class NZBDownload
{
  /**
   * @param $id
   * @return string nzbfile
   */
  public function get($id)
  {
    Logger::log("New nzb download: " . json_encode($_GET));

    $town = new TownProvider();
    $nzbInfo = $town->getNZBInformation($id);
    $nzblink = $nzbInfo->link;

    if (!empty($nzblink)) {
      $nzbfile = $town->getNZBFile($nzblink);
      $filename = $this->extractFilename($nzblink);

      //Attach password if available
      if ($nzbInfo->password != "") {
        $this->attachPassword($filename, $nzbInfo, $nzbfile);
      }

      Logger::log("Filename: " . $filename);
      return $this->returnNZBFile($nzbfile, $filename);

    } else {
      Misc::showApiError(300, 'No such item (the guid you provided has no release in our database)');
    }
  }

  /**
   * @param $nzblink
   * @return bool|string
   */
  private function extractFilename($nzblink)
  {
    $parts = explode("/", $nzblink);
    $filenameWithID = $parts[count($parts) - 1];
    $filename = substr($filenameWithID, strpos($filenameWithID, "-") + 1);
    return $filename;
  }

  /**
   * @param $filename
   * @param $nzbInfo
   * @param $nzbfile
   */
  private function attachPassword(&$filename, $nzbInfo, &$nzbfile)
  {
// Add password to nzb filename
    if (NZB_PASSWORD_URL) {
      $filename = substr($filename, 0, -4);
      $filename = trim($filename . " password=" . $nzbInfo->password . ".nzb");
    }

    // Add password to http header
    if (NZB_PASSWORD_HTTP_HEADER) {
      header("x-dnzb-password:" . $nzbInfo->password);
    }

    // Embed password in nzb
    if (NZB_PASSWORD_EMBED_NZB) {
      $dom = new DOMDocument('1.0', 'utf-8');
      $dom->formatOutput = true;
      $dom->loadXML($nzbfile);
      $domHead = $dom->createElement("head");
      $dom->insertBefore($domHead, $dom->firstChild);
      $domMeta = $dom->createElement("meta", $nzbInfo->password);
      $domMeta->setAttribute("type", "password");
      $domHead->appendChild($domMeta);

      $nzbfile = $dom->saveXML();
    }
  }

  /**
   * @param $nzbfile
   * @param $filename
   */
  private function returnNZBFile($nzbfile, $filename)
  {
    header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
    header("Cache-Control: public"); // needed for internet explorer
    header("Content-Type: application/x-nzb");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length:" . strlen($nzbfile));
    header("Content-Disposition: attachment; filename=\"$filename\"");

    return $nzbfile;
  }
}
