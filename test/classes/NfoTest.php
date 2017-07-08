<?php

namespace Board2NZB;
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config.php';

use PHPUnit\Framework\TestCase;

class NfoTest extends TestCase
{
  /**
   * @runInSeparateProcess
   */
  /*  public function testGetNfo()
    {
      $nfo = new Nfo();

      ob_start(null,0,PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_FLUSHABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
      $nfo->get();
      $result = ob_get_clean();

      self::assertTrue(preg_match_all("/Function not available/",$result));

      //echo $result;
    }*/
}
