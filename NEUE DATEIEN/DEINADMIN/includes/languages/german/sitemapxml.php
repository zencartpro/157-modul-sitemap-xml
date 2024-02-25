<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml.php 2024-02-25 18:57:16Z webchills $
 */

define('HEADING_TITLE', 'Sitemap XML');
define('TEXT_SITEMAPXML_TIPS_HEAD', 'Tips');
define('TEXT_SITEMAPXML_INSTRUCTIONS_HEAD', 'Sitemap(s) anlegen/aktualisieren');
define('TEXT_SITEMAPXML_CHOOSE_PARAMETERS_REBUILD', 'Alle sitemap*.xml Dateien neu generieren!');
define('ERROR_SITEMAPXML_TOKEN_INVALID_HDR', 'Sitemaps können nicht erzeugt werden');
define('ERROR_SITEMAPXML_TOKEN_INVALID_MESSAGE', 'Der angegebene Token (%1$s) enthält ungültige Zeichen.');

define('TEXT_SITEMAPXML_ROBOTS_HDR','Ihre <code>robots.txt</code> Datei');
define('SUCCESS_SITEMAPXML_ROBOTS_TXT_OK','Ihre <code>robots.txt</code> verweist Suchmaschinen auf Ihre <code>%1$s</code> Sitemap XML!');
define('WARNING_SITEMAPXML_NO_ROBOTS_FILE','Ihr Shop hat keine <code>robots.txt</code> Datei! Suchmaschinen wissen daher nichts von Ihrer Sitemap.');
define('WARNING_SITEMAPXML_NO_ROBOTS_TEXT','Ihre <code>robots.txt</code> Datei verweist nicht auf Ihre Sitemap XML Datei.Fügen Sie den Eintrag <code>Sitemap: %1$s</code> zu Ihrer robots.txt Datei hinzu.');

define('TEXT_SITEMAPXML_PLUGINS_LIST', 'Sitemap Plugins');
define('TEXT_SITEMAPXML_PLUGINS_LIST_SELECT', 'Wählen Sie die zu erstellenden Sitemaps');

define('TEXT_SITEMAPXML_FILE_LIST', 'Liste aller Sitemaps');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_FNAME', 'Name');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_FSIZE', 'Größe');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_FTIME', 'zuletzt geändert');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_FPERMS', 'Dateirechte');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_TYPE', 'Typ');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_ITEMS', 'Einträge');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_COMMENTS', 'Kommentare');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_ACTION', 'Aktion');

define('TEXT_SITEMAPXML_IMAGE_POPUP_ALT', 'Sitemap in neuem Fenster öffnen');
define('TEXT_SITEMAPXML_RELOAD_WINDOW', 'Dateiliste neu laden');

define('TEXT_SITEMAPXML_FILE_LIST_COMMENTS_READONLY', 'Read Only!!!');
define('TEXT_SITEMAPXML_FILE_LIST_COMMENTS_IGNORED', 'Ignored');

define('TEXT_SITEMAPXML_FILE_LIST_TYPE_URLSET', 'UrlSet');
define('TEXT_SITEMAPXML_FILE_LIST_TYPE_SITEMAPINDEX', 'SitemapIndex');
define('TEXT_SITEMAPXML_FILE_LIST_TYPE_UNDEFINED', 'Undefined!!!');

define('TEXT_ACTION_VIEW_FILE', 'Ansehen');
define('TEXT_ACTION_TRUNCATE_FILE', 'Leeren');
define('TEXT_ACTION_TRUNCATE_FILE_CONFIRM', 'Möchten Sie den Inhalt der Datei %s wirklich leeren?');
define('TEXT_ACTION_DELETE_FILE', 'Löschen');
define('TEXT_ACTION_DELETE_FILE_CONFIRM', 'Möchten Sie die Datei %s wirklich löschen?');

define('TEXT_MESSAGE_FILE_ERROR_OPENED', 'Fehler beim Öffnen der Datei %s');
define('TEXT_MESSAGE_FILE_TRUNCATED', 'Dateiinhalt %s geleert');
define('TEXT_MESSAGE_FILE_DELETED', 'Datei %s gelöscht');
define('TEXT_MESSAGE_FILE_ERROR_DELETED', 'Fehler - gelöschte Datei %s');

define('TEXT_SITEMAPXML_TIPS_TEXT', '<p>Informationen zum Thema Sitemaps finden Sie auf <strong><a href="http://sitemaps.org/" target="_blank" rel="noopener noreferrer" class="splitPageLink">[Sitemaps.org]</a></strong>.</p>
<p>Sobald die Sitemaps erstellt wurden, sollten Sie die Suchmaschinen darüber benachrichtigen:</p>
<ol>
<li>Melden Sie sich dazu bei <strong><a href="https://www.google.com/webmasters/tools/home" target="_blank" rel="noopener noreferrer" class="splitPageLink">[Google]</a></strong> und bei <strong><a href="https://ssl.bing.com/webmaster" target="_blank" rel="noopener noreferrer" class="splitPageLink">[Bing]</a></strong> an.</li>
<li>Übermitteln Sie Ihre Sitemap, z.B. <code>https://www.meinshop.de/sitemap.xml</code> über das Interface der Suchmaschine <strong><a href="https://www.google.com/webmasters/tools/home" target="_blank" rel="noopener noreferrer" class="splitPageLink">[Google]</a></strong>.</li>
<li>Geben Sie den Ort Ihrer Sitemap an in Ihrer <a href="' . HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'robots.txt' . '" target="_blank" class="splitPageLink">robots.txt</a> Datei (<a href="https://sitemaps.org/protocol.php#submit_robots" target="_blank" rel="noopener noreferrer" class="splitPageLink">mehr Info...</a>): <code>Sitemap: https://www.meinshop.de/sitemap.xml</code></li>
</ol>
<p>Um die Sitemaps <em>automatisch</em> zu aktualisieren richten Sie einen Cronjob ein.</p>
<p>Wenn Sie einen solchen Cronjob verwenden, dann stellen Sie in der Sitemap XML Konfiguration unbedingt eine Security Token ein, um zu verhindern, dass Aufrufe an das Sitemap Script ohne Token erfolgen und damit für DDOS Attacken missbraucht werden können.</p>
<p>Falls Ihr Provider das Eingeben von einfachen https Links beim Anlegen eines Cronjobs unterstützt, dann wäre einfach z.B. folgende URL einzugeben, um das ganze zusätzlich mit der Token abzusichern (Token in diesem Beispiel 12345):<br/>
<code>https://www.meinshop.de/index.php?main_page=sitemapxml&rebuild=yes&token=12345</code>
</p>
<p>Um den Cronjob z.B. um 5 Uhr morgens laufen zu lassen, könnte ein Eintrag in der Crontable so aussehen (entsprechend anpassen)</p>
        <samp>0 5 * * * GET \'https://your_domain/index.php?main_page=sitemapxml&amp;rebuild=yes%1$s\'</samp><br>
        <samp>0 5 * * * wget -q \'https://your_domain/index.php?main_page=sitemapxml&amp;rebuild=yes%1$s\' -O /dev/null</samp><br>
        <samp>0 5 * * * curl -s \'https://your_domain/index.php?main_page=sitemapxml&amp;rebuild=yes%1$s\'</samp><br>
        <samp>0 5 * * * php -f &lt;path to shop&gt;/cgi-bin/sitemapxml.php rebuild=yes%2$s</samp><br>');

