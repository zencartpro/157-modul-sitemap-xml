<?php
/**
 * Sitemap XML Feed
 *
 * @package Sitemap XML Feed
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart-pro.at/license/2_0.txt GNU Public License V2.0
 * @version $Id: sitemapxml.php 2018-10-24 17:19:33 webchills $
 */

define('SITEMAPXML_SITEMAPINDEX_HTTP_LINK', HTTP_CATALOG_SERVER . DIR_WS_CATALOG . SITEMAPXML_SITEMAPINDEX . '.xml');
define('HEADING_TITLE', 'Sitemap XML');
define('TEXT_SITEMAPXML_TIPS_HEAD', 'Tips');
define('TEXT_SITEMAPXML_TIPS_TEXT', '<p>Informationen zum Thema Sitemaps finden Sie auf <strong><a href="http://sitemaps.org/" target="_blank" class="splitPageLink">[Sitemaps.org]</a></strong>.</p>
<p>Sobald die Sitemaps erstellt wurden, sollten Sie die Suchmaschinen darüber benachrichtigen:</p>
<ol>
<li>Melden Sie sich dazu bei <strong><a href="https://www.google.com/webmasters/tools/home" target="_blank" class="splitPageLink">[Google]</a></strong> und bei <strong><a href="https://ssl.bing.com/webmaster" target="_blank" class="splitPageLink">[Bing]</a></strong> an.</li>
<li>Reichen Sie Ihre Sitemap <input type="text" readonly="readonly" value="' . SITEMAPXML_SITEMAPINDEX_HTTP_LINK . '" size="' . strlen(SITEMAPXML_SITEMAPINDEX_HTTP_LINK) . '" style="border: solid 1px; padding: 0 4px 0 4px;"/> über das Webinterface der Suchmaschine ein <strong><a href="https://www.google.com/webmasters/tools/home" target="_blank" class="splitPageLink">[Google]</a></strong>, <strong><a href="http://www.bing.com/webmaster/WebmasterAddSitesPage.aspx" target="_blank" class="splitPageLink">[Bing]</a></strong>.</li>
<li>Geben Sie den Link zu Sitemap zusätzlich in der <a href="' . HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'robots.txt' . '" target="_blank" class="splitPageLink">robots.txt</a> an:<br /><input type="text" readonly="readonly" value="Sitemap: ' . SITEMAPXML_SITEMAPINDEX_HTTP_LINK . '" size="' . strlen('Sitemap: ' . SITEMAPXML_SITEMAPINDEX_HTTP_LINK) . '" style="border: solid 1px; padding: 0 4px 0 4px;"/></li>
<li>Wenn Sie beim Aktualisieren der Sitemap zusätzlich ankreuzen, dass die Suchmaschinen über die Aktualsierung benachrichtigt wreden sollen, dann werden Google und Bing via CURL Request informiert.</li>
</ol>
<p>Um die Sitemaps <em>automatisch</em> zu aktualisieren und Bing und Google darüber zu informieren, richten Sie einen Cronjob ein.</p>
<p>Um den Cronjob z.B. um 5 Uhr morgens laufen zu lassen, könnte ein Eintrag in der Crontable so aussehen (entsprechend anpassen)</p>
<p>0 5 * * * GET \'http://your_domain/index.php?main_page=sitemapxml\&amp;rebuild=yes\&amp;ping=yes\'</p>
<p>0 5 * * * wget -q \'http://your_domain/index.php?main_page=sitemapxml\&amp;rebuild=yes\&amp;ping=yes\' -O /dev/null</p>
<p>0 5 * * * curl -s \'http://your_domain/index.php?main_page=sitemapxml\&amp;rebuild=yes\&amp;ping=yes\'</p>
<p>0 5 * * * php -f &lt;path to shop&gt;/cgi-bin/sitemapxml.php rebuild=yes ping=yes</p>
<p>Wenn Sie einen solchen Cronjob verwenden, dann stellen Sie in der Sitemap XML Konfiguration unbedingt eine Security Token ein, um zu verhindern, dass Aufrufe an das Sitemap Script ohne Token erfolgen und damit für DDOS Attacken missbraucht werden können.</p>
<p>Falls Ihr Provider das Eingeben von einfachen https Links beim Anlegen eines Cronjobs unterstützt, dann wäre einfach z.B. folgende URL einzugeben, um das ganze zusätzlich mit der Token abzusichern (Token in diesem Beispiel 12345):<br/>
https://www.meinshop.de/index.php?main_page=sitemapxml&rebuild=yes&ping=yes&token=12345
</p>
');

define('TEXT_SITEMAPXML_INSTRUCTIONS_HEAD', 'Sitemap(s) erstellen/aktualisieren');
define('TEXT_SITEMAPXML_CHOOSE_PARAMETERS', 'Aktion wählen');
define('TEXT_SITEMAPXML_CHOOSE_PARAMETERS_PING', 'Ping an Suchmaschinen');
define('TEXT_SITEMAPXML_CHOOSE_PARAMETERS_REBUILD', 'Aktualisiere alle sitemap*.xml Dateien');
define('TEXT_SITEMAPXML_CHOOSE_PARAMETERS_INLINE', 'Generierte Datei ' . SITEMAPXML_SITEMAPINDEX . '.xml');

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
define('TEXT_MESSAGE_LANGUGE_FILE_NOT_FOUND', 'SitemapXML Sprachdatei wurde nicht gefunden %s - die deutsche Sprachdatei wird verwendet.');