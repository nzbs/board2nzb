<?php

namespace Board2NZB;

class Category
{
  /**
   * Category constants.
   * Do NOT use the values, as they may change, always use the constant - that's what it's for.
   */
  const BOOKS_COMICS = '7030';
  const BOOKS_EBOOK = '7020';
  const BOOKS_FOREIGN = '7060';
  const BOOKS_MAGAZINES = '7010';
  const BOOKS_ROOT = '7000';
  const BOOKS_TECHNICAL = '7040';
  const BOOKS_UNKNOWN = '7999';
  const GAME_3DS = '1110';
  const GAME_NDS = '1010';
  const GAME_OTHER = '1999';
  const GAME_PS3 = '1080';
  const GAME_PS4 = '1180';
  const GAME_PSP = '1020';
  const GAME_PSVITA = '1120';
  const GAME_ROOT = '1000';
  const GAME_WII = '1030';
  const GAME_WIIU = '1130';
  const GAME_WIIWARE = '1060';
  const GAME_XBOX = '1040';
  const GAME_XBOX360 = '1050';
  const GAME_XBOX360DLC = '1070';
  const GAME_XBOXONE = '1140';
  const MOVIE_3D = '2050';
  const MOVIE_BLURAY = '2060';
  const MOVIE_DVD = '2070';
  const MOVIE_FOREIGN = '2010';
  const MOVIE_HD = '2040';
  const MOVIE_OTHER = '2999';
  const MOVIE_ROOT = '2000';
  const MOVIE_SD = '2030';
  const MOVIE_WEBDL = '2080';
  const MUSIC_AUDIOBOOK = '3030';
  const MUSIC_FOREIGN = '3060';
  const MUSIC_LOSSLESS = '3040';
  const MUSIC_MP3 = '3010';
  const MUSIC_OTHER = '3999';
  const MUSIC_ROOT = '3000';
  const MUSIC_VIDEO = '3020';
  const OTHER_HASHED = '0020';
  const OTHER_MISC = '0010';
  const OTHER_ROOT = '0000';
  const PC_0DAY = '4010';
  const PC_GAMES = '4050';
  const PC_ISO = '4020';
  const PC_MAC = '4030';
  const PC_PHONE_ANDROID = '4070';
  const PC_PHONE_IOS = '4060';
  const PC_PHONE_OTHER = '4040';
  const PC_ROOT = '4000';
  const TV_ANIME = '5070';
  const TV_DOCUMENTARY = '5080';
  const TV_FOREIGN = '5020';
  const TV_HD = '5040';
  const TV_OTHER = '5999';
  const TV_ROOT = '5000';
  const TV_SD = '5030';
  const TV_SPORT = '5060';
  const TV_WEBDL = '5010';
  const XXX_DVD = '6010';
  const XXX_IMAGESET = '6060';
  const XXX_OTHER = '6999';
  const XXX_PACKS = '6070';
  const XXX_ROOT = '6000';
  const XXX_SD = '6080';
  const XXX_WEBDL = '6090';
  const XXX_WMV = '6020';
  const XXX_X264 = '6040';
  const XXX_XVID = '6030';

  const STATUS_INACTIVE = 0;
  const STATUS_ACTIVE = 1;
  const STATUS_DISABLED = 2;

  public static function getCategories()
  {
    return array(
        array('id' => self::TV_ROOT, 'title' => 'TV', 'description' => '', 'subcatlist' => array()),
        array('id' => self::MOVIE_ROOT, 'title' => 'Movies', 'description' => '', 'subcatlist' => array()),
    );
  }
}
