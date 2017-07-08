<?php

namespace Board2NZB;

class NzbInformation {

  public $link;
  public $password;

  public function __construct($link, $password) {
    $this->link = $link;
    $this->password = $password;
  }
}