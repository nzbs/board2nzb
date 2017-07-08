<?php

namespace Board2NZB;

class SearchResult {

  public $title;
  public $link;
  public $category;
  public $categoryLink;
  public $category_ids;

  public function __construct($title, $link, $category, $categoryLink) {

    $this->title = $title;
    $this->link = $link;
    $this->category = $category;
    $this->categoryLink = $categoryLink;
    $this->category_ids = array();
  }
}
