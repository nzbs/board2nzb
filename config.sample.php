<?php

# General Settings
define("ROOTPATH", "/var/www/board2nzb/");
define("WEBPATH", "http://localhost/board2nzb/");
define("APIKEY", "changeMe"); # API-Key checked when accessing the API

#NZB Passwords
# Try to retrieve the password and include it in the nzb download.
# See https://sabnzbd.org/wiki/advanced/password-protected-rars
define("NZB_PASSWORD_URL", false); #Warning: Does not work with all special characters
define("NZB_PASSWORD_HTTP_HEADER", true);
define("NZB_PASSWORD_EMBED_NZB", true);

# TownProvider
define("USERNAME", "user");
define("PASSWORD", "pass");
define("TOWN_BASE_URL", "http://www.town.ag/v2/");

# Logging
define("LOG_ENABLED", false);
define("LOG_FILE", "/var/log/board2nzb.log");
define("LOG_LEVEL", E_ALL);

# TVDB
define('TVDB_API_KEY', '');
define('TVDB_USERNAME', '');
define('TVDB_USERKEY', '');
