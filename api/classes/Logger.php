<?php

namespace Board2NZB;

class Logger {
  public static function log($message, $level = E_NOTICE) {
    if(LOG_ENABLED && $level <= LOG_LEVEL) {
      $message = date('Y-m-d H:i:s') . ": " . $message . "\r\n";
      error_log($message, 3, LOG_FILE);
    }
  }
}