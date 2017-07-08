# Board2NZB: Connect your Sickrage/Sickbeard with your favorite NZB-Board.

This tool offers a (minimalistic) newznab api to connect with 
Sickrage / Sickbeard and translates searches to search queries 
in the board. Search results are returned via the api and NZB-Files 
can be downloaded directly to SABnzbd.
Currently only the town.ag-Board is supported, but feel free to add additional search providers.

## How to install
1. Checkout the git repository to your webserver root: `git clone ... `
2. Install dependencies using [composer](https://getcomposer.org/): `composer install`
3. Create your custom config.php using config.sample.php

## Perform the first search
Open index.php in your browser and use the search field to receive results and test your configuration.

## How to integrate with sickrage / sickbeard
1. Create a new custom search provider (e.g. with Site URL: http://localhost/board2nzb)
2. Disable daily searches in the provider options
3. Enable provider for backlog searches
4. In the search settings increase the 'backlog search frequency' (e.g. to 7200)


**Important:** Use this search provider only for backlog search and reduce search frequenzy to a minimum (e.g. 5 days) 
to not to flood the board with search requests.

## Open issues
* Embedding the password in the NZB leads to the following error in SABnzbd: "junk after document element auf Zeile 6". The error disappears when manually removing the header part.


## Credits
- This tool is based on [nZEDb](https://github.com/nZEDb/nZEDb) However most of the code is rewritten.
- Uses some scripts from https://ageek.de/131/vbulletin-login-mit-curl/
