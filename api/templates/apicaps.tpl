<?xml version="1.0" encoding="UTF-8" ?>
<caps>
    <server appversion="1.0.0" version="0.1" title="Board2NZB" strapline="" email="noreplay@example.com"
            url="{$serverroot}" image="{$serverroot}img/logo.png"/>
    <limits max="100" default="100"/>
    <registration available="no" open="no"/>
    <searching>
        <search available="yes" supportedParams="q,group"/>
        <tv-search available="yes" supportedParams="q,rid,tvdbid,season,ep"/>
        <movie-search available="no" supportedParams="q,imdbid,genre"/>
        <audio-search available="no" supportedParams="q,album,artist,label,year,genre"/>
    </searching>
    <categories>
        <category id="2000" name="Movies">
            <subcat id="2010" name="Foreign" description="Movies"/>
            <subcat id="2020" name="Other" description="Movies"/>
            <subcat id="2030" name="SD" description="Movies"/>
            <subcat id="2040" name="HD" description="Movies"/>
            <subcat id="2050" name="BluRay" description="Movies"/>
            <subcat id="2060" name="3D" description="Movies"/>
            <subcat id="2070" name="DVD" description="Movies"/>
            <subcat id="2080" name="WEB-DL" description="Movies"/>
        </category>
        <category id="5000" name="TV">
            <subcat id="5010" name="WEB-DL" description="TV"/>
            <subcat id="5020" name="Foreign" description="TV"/>
            <subcat id="5030" name="SD" description="TV"/>
            <subcat id="5040" name="HD" description="TV"/>
            <subcat id="5050" name="Other" description="TV"/>
            <subcat id="5060" name="Sport" description="TV"/>
            <subcat id="5070" name="Anime" description="TV"/>
            <subcat id="5080" name="Documentary" description="TV"/>
        </category>
    </categories>
    <genres>
    </genres>
</caps>
