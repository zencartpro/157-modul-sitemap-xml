<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 4_0_0.php 2022-06-08 20:37:16Z webchills $
 */
 
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'Sitemap XML'
LIMIT 1;");


$db->Execute("INSERT IGNORE INTO ".TABLE_CONFIGURATION." (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, last_modified, use_function, set_function) VALUES
('SitemapXML Index file name', 'SITEMAPXML_SITEMAPINDEX', 'sitemap', 'SitemapXML Index file name - this file should be given to the search engines', @gid, 2, now(), now(), '', ''),
('Sitemap directory', 'SITEMAPXML_DIR_WS', 'sitemap', 'Directory for sitemap files. If empty all sitemap xml files saved on shop root directory.', @gid, 3, now(), now(), '', ''),
('Compress SitemapXML Files', 'SITEMAPXML_COMPRESS', 'false', 'Compress SitemapXML files', @gid, 4, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Lastmod tag format', 'SITEMAPXML_LASTMOD_FORMAT', 'date', 'Lastmod tag format:<br />date - Complete date: YYYY-MM-DD (eg 1997-07-16)<br />full -    Complete date plus hours, minutes and seconds: YYYY-MM-DDThh:mm:ssTZD (eg 1997-07-16T19:20:30+01:00)', @gid, 5, now(), now(), '', 'zen_cfg_select_option(array(\'date\', \'full\'),'),
('Start Security Token', 'SITEMAPXML_EXECUTION_TOKEN', '6Tgvf12TVc8', 'Used to prevent a third party not authorized start of the generator Sitemap XML. To avoid the creation of intentional excessive load on the server, DDoS-attacks.', @gid, 6, now(), now(), '', ''),
('Use Existing Files', 'SITEMAPXML_USE_EXISTING_FILES', 'true', 'Use Existing XML Files', @gid, 7, now(), '2015-10-30 16:35:18', '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Generate links only for default language', 'SITEMAPXML_USE_ONLY_DEFAULT_LANGUAGE', 'false', 'Generate links for all languages or only for default language', @gid, 8, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Using parameter language in links', 'SITEMAPXML_USE_LANGUAGE_PARM', 'true', 'Using parameter language in links:<br />true - normally use it,<br />all - using for all langusges including pages for default language,<br />false - don\'t use it', @gid, 9, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'all\', \'false\'),'),
('Check Duplicates', 'SITEMAPXML_CHECK_DUPLICATES', 'true', 'true - check duplicates,<br />mysql - check duplicates using mySQL (used to store a large number of products),<br />false - don\'t check duplicates', @gid, 10, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'mysql\', \'false\'),'),
('Active plugins', 'SITEMAPXML_PLUGINS', 'sitemapxml_categories.php;sitemapxml_ezpages.php;sitemapxml_mainpage.php;sitemapxml_manufacturers.php;sitemapxml_products.php;sitemapxml_products_reviews.php;sitemapxml_reviews.php', 'What plug-ins from existing uses to generate the site map', @gid, 11, now(), now(), '', 'zen_cfg_read_only('),
('Ping urls', 'SITEMAPXML_PING_URLS', 'Google => http://www.google.com/webmasters/sitemaps/ping?sitemap=%s;\r\nBing => http://www.bing.com/webmaster/ping.aspx?siteMap=%s', 'List of pinging urls separated by ;', @gid, 12, now(), now(), '', 'zen_cfg_textarea('),
('Home page order by', 'SITEMAPXML_HOMEPAGE_ORDERBY', 'sort_order ASC', '', @gid, 13, now(), now(), '', ''),
('Home page changefreq', 'SITEMAPXML_HOMEPAGE_CHANGEFREQ', 'weekly', 'How frequently the Home page is likely to change.', @gid, 14, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
('Products order by', 'SITEMAPXML_PRODUCTS_ORDERBY', 'products_sort_order ASC, last_date DESC', '', @gid, 15, now(), now(), '', ''),
('Products changefreq', 'SITEMAPXML_PRODUCTS_CHANGEFREQ', 'weekly', 'How frequently the Product pages page is likely to change.', @gid, 16, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
('Use cPath parameter', 'SITEMAPXML_PRODUCTS_USE_CPATH', 'false', 'Use cPath parameter in products url. Coordinate this value with the value of variable includeCPath in file init_canonical.php', @gid, 17, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Add Products Images', 'SITEMAPXML_PRODUCTS_IMAGES', 'false', 'Generate Products Image tags for products urls', @gid, 18, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Use Products Images Caption/Title', 'SITEMAPXML_PRODUCTS_IMAGES_CAPTION', 'false', 'Generate Product image tags Title and Caption', @gid, 19, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Products Images license', 'SITEMAPXML_PRODUCTS_IMAGES_LICENSE', '', 'A URL to the license of the Products images', @gid, 20, now(), now(), '', ''),
('Categories order by', 'SITEMAPXML_CATEGORIES_ORDERBY', 'sort_order ASC, last_date DESC', '', @gid, 21, now(), now(), '', ''),
('Category changefreq', 'SITEMAPXML_CATEGORIES_CHANGEFREQ', 'weekly', 'How frequently the Category pages page is likely to change.', @gid, 22, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
('Add Categories Images', 'SITEMAPXML_CATEGORIES_IMAGES', 'false', 'Generate Categories Image tags for categories urls', @gid, 23, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Use Categories Images Caption/Title', 'SITEMAPXML_CATEGORIES_IMAGES_CAPTION', 'false', 'Generate Categories image tags Title and Caption', @gid, 24, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Categories Images license', 'SITEMAPXML_CATEGORIES_IMAGES_LICENSE', '', 'A URL to the license of the Categories images', @gid, 25, now(), now(), '', ''),
('Reviews order by', 'SITEMAPXML_REVIEWS_ORDERBY', 'reviews_rating ASC, last_date DESC', '', @gid, 26, now(), now(), '', ''),
('Reviews changefreq', 'SITEMAPXML_REVIEWS_CHANGEFREQ', 'weekly', 'How frequently the Reviews pages page is likely to change.', @gid, 27, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
('EZPages order by', 'SITEMAPXML_EZPAGES_ORDERBY', 'sidebox_sort_order ASC, header_sort_order ASC, footer_sort_order ASC', '', @gid, 28, now(), now(), '', ''),
('EZPages changefreq', 'SITEMAPXML_EZPAGES_CHANGEFREQ', 'weekly', 'How frequently the EZPages pages page is likely to change.', @gid, 29, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
('Testimonials order by', 'SITEMAPXML_TESTIMONIALS_ORDERBY', 'last_date DESC', '', @gid, 30, now(), now(), '', ''),
('Testimonials changefreq', 'SITEMAPXML_TESTIMONIALS_CHANGEFREQ', 'weekly', 'How frequently the Testimonials page is likely to change.', @gid, 31, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
('News Articles order by', 'SITEMAPXML_NEWS_ORDERBY', 'last_date DESC', '', @gid, 32, now(), now(), '', ''),
('News Articles changefreq', 'SITEMAPXML_NEWS_CHANGEFREQ', 'weekly', 'How frequently the News Articles is likely to change.', @gid, 33, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
('Manufacturers order by', 'SITEMAPXML_MANUFACTURERS_ORDERBY', 'last_date DESC', '', @gid, 34, now(), now(), '', ''),
('Manufacturers changefreq', 'SITEMAPXML_MANUFACTURERS_CHANGEFREQ', 'weekly', 'How frequently the Manufacturers is likely to change.', @gid, 35, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
('Add Manufacturers Images', 'SITEMAPXML_MANUFACTURERS_IMAGES', 'false', 'Generate Manufacturers Image tags for manufacturers urls', @gid, 36, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Use Images Caption/Title', 'SITEMAPXML_MANUFACTURERS_IMAGES_CAPTION', 'false', 'Generate Manufacturer image tags Title and Caption', @gid, 37, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Manufacturers Images license', 'SITEMAPXML_MANUFACTURERS_IMAGES_LICENSE', '', 'A URL to the license of the Manufacturers images', @gid, 38, now(), now(), '', ''),
('Products Reviews - order by', 'SITEMAPXML_PRODUCTS_REVIEWS_ORDERBY', 'last_date DESC', '', @gid, 39, now(), now(), '', ''),
('Products Reviews - changefreq', 'SITEMAPXML_PRODUCTS_REVIEWS_CHANGEFREQ', 'weekly', 'How frequently the Products Reviews is likely to change.', @gid, 40, now(), now(), '', ''),
('News Box Manager - order by', 'SITEMAPXML_BOXNEWS_ORDERBY', 'last_date DESC', '', @gid, 41, now(), now(), '', ''),
('News Box Manager - changefreq', 'SITEMAPXML_BOXNEWS_CHANGEFREQ', 'weekly', 'How frequently the News Box Manager is likely to change.', @gid, 42, now(), now(), '', 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),')");

$db->Execute("REPLACE INTO ".TABLE_CONFIGURATION_LANGUAGE." (configuration_title, configuration_key, configuration_description, configuration_language_id) VALUES
('News Box Manager - Sortierung', 'SITEMAPXML_BOXNEWS_ORDERBY', '', 43),
('Hersteller Bilder - Lizenzinfo', 'SITEMAPXML_MANUFACTURERS_IMAGES_LICENSE', 'URL zu einer Lizenzinfo für die Hersteller Bilder', 43),
('Artikelbewertungen - Sortierung', 'SITEMAPXML_PRODUCTS_REVIEWS_ORDERBY','', 43),
('Artikelbewertungen - Änderungshäufigkeit', 'SITEMAPXML_PRODUCTS_REVIEWS_CHANGEFREQ', 'Wie oft ändern sich die Artikelbewertungen normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('Hersteller Bilder - Verwenden?', 'SITEMAPXML_MANUFACTURERS_IMAGES', 'Hersteller Image-Tags für Hersteller-URLs generieren?', 43),
('Hersteller Bilder - Caption/Titel', 'SITEMAPXML_MANUFACTURERS_IMAGES_CAPTION', 'Titel und Caption Image Tags für Hersteller-URLs generieren?', 43),
('Hersteller - Änderungshäufigkeit', 'SITEMAPXML_MANUFACTURERS_CHANGEFREQ', 'Wie oft ändern sich die Hersteller normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('Testimonials - Änderungshäufigkeit', 'SITEMAPXML_TESTIMONIALS_CHANGEFREQ', 'Wie oft ändern sich die Testimonials normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('Hersteller - Sortierung', 'SITEMAPXML_MANUFACTURERS_ORDERBY', '', 43),
('Newsbeiträge - Änderungshäufigkeit', 'SITEMAPXML_NEWS_CHANGEFREQ', 'Wie oft ändern sich die Newsbeiträge normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('Newsbeiträge - Sortierung', 'SITEMAPXML_NEWS_ORDERBY','', 43),
('Testimonials - Sortierung', 'SITEMAPXML_TESTIMONIALS_ORDERBY', '', 43),
('Bewertungen - Änderungshäufigkeit', 'SITEMAPXML_REVIEWS_CHANGEFREQ', 'Wie oft ändern sich die Bewertungen normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('EZ Pages - Sortierung', 'SITEMAPXML_EZPAGES_ORDERBY','', 43),
('EZ Pages - Änderungshäufigkeit', 'SITEMAPXML_EZPAGES_CHANGEFREQ','Wie oft ändern sich die EZ Pages normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('Kategorie Bilder - Lizenzinfo', 'SITEMAPXML_CATEGORIES_IMAGES_LICENSE', 'URL zu einer Lizenzinfo für die Kategorie Bilder', 43),
('Bewertungen - Sortierung', 'SITEMAPXML_REVIEWS_ORDERBY', '', 43),
('Kategorien - Sortierung', 'SITEMAPXML_CATEGORIES_ORDERBY', '', 43),
('Kategorien - Änderungshäufigkeit', 'SITEMAPXML_CATEGORIES_CHANGEFREQ', 'Wie oft ändern sich die Kategorien normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('Kategorie Bilder - Verwenden?', 'SITEMAPXML_CATEGORIES_IMAGES', 'Kategorie Image-Tags für Kategorie-URLs generieren?', 43),
('Kategorie Bilder - Caption/Titel', 'SITEMAPXML_CATEGORIES_IMAGES_CAPTION', 'Titel und Caption Image Tags für Kategorie-URLs generieren?', 43),
('Artikel Bilder - Lizenzinfo', 'SITEMAPXML_PRODUCTS_IMAGES_LICENSE', 'URL zu einer Lizenzinfo für die Artikel Bilder', 43),
('Artikel Bilder - Verwenden?', 'SITEMAPXML_PRODUCTS_IMAGES', 'Artikel Image-Tags für Artikel-URLs generieren?', 43),
('Artikel Bilder - Caption/Titel', 'SITEMAPXML_PRODUCTS_IMAGES_CAPTION', 'Titel und Caption Image Tags für Artikel-URLs generieren?', 43),
('cPath verwenden?', 'SITEMAPXML_PRODUCTS_USE_CPATH', 'Soll in den URLs der cPath mitaufgenommen werden?', 43),
('Artikel - Sortierung', 'SITEMAPXML_PRODUCTS_ORDERBY', '', 43),
('Artikel - Änderungshäufigkeit', 'SITEMAPXML_PRODUCTS_CHANGEFREQ', 'Wie oft ändern sich die Artikel normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('Startseite - Sortierung', 'SITEMAPXML_HOMEPAGE_ORDERBY', '', 43),
('Startseite - Änderungshäufigkeit', 'SITEMAPXML_HOMEPAGE_CHANGEFREQ', 'Wie oft ändert sich die Startseite normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43),
('Aktivierte Plugins', 'SITEMAPXML_PLUGINS', 'Dies ist eine read only Einstellung, die die derzeit aktivierten Plugins ausliest.<br/>Änderungen dazu nehmen Sie unter Tools > Sitemap XML vor.', 43),
('Ping URLs', 'SITEMAPXML_PING_URLS', 'URLs zum Pingen der Suchmaschinen kommagetrennt', 43),
('Sprachkürzel in den Links verwenden?', 'SITEMAPXML_USE_LANGUAGE_PARM', 'Verwendung des Parameters Sprache in den Links:<br />true - normale Verwendung<br />all - Verwendung für alle Sprachen, einschließlich der Standardsprache,<br />false - nicht verwenden.', 43),
('Duplikate prüfen', 'SITEMAPXML_CHECK_DUPLICATES', 'true - Duplikate werden vom Script geprüft<br />mysql - Duplikate werden per mySQL geprüft (bei sehr hoher Artikelanzahl empfohlen),<br />false - Nicht auf Duplikate prüfen', 43),
('Links nur für die Standardsprache generieren?', 'SITEMAPXML_USE_ONLY_DEFAULT_LANGUAGE', 'Links nur für die Standardsprache oder für alle Sprachen generieren?', 43),
('Sicherheits Token', 'SITEMAPXML_EXECUTION_TOKEN', 'Tragen Sie hier unbedingt eine Token aus Zahlen und Buchstaben ein. Ändern Sie den voreingestellten Token auf einen Ihrer Wahl!<br/>Nur wenn der Link zur Sitemapgenerierung dann den Token enthält, wird die Sitemap generiert. Das verhindert dass jemand ohne Berechtigung durch permanentes Aufrufen des Links Ihren Server lahmlegen kann.<br/>Weitere Infos zum Verwenden der automatisierten Sitemapaktualisierung per Cronjob unter Tools > Sitemap XML', 43),
('Bestehende Dateien verwenden?', 'SITEMAPXML_USE_EXISTING_FILES', 'Bereits angelegte XML Sitemap Dateien verwenden und beim Aktualisieren überschreiben?', 43),
('Format für letzte Änderung', 'SITEMAPXML_LASTMOD_FORMAT', 'Lastmod tag format:<br />date - Complete date: YYYY-MM-DD (eg 2018-10-24)<br />full -  Complete date plus hours, minutes and seconds: YYYY-MM-DDThh:mm:ssTZD (eg 2018-10-24T19:20:30+01:00)', 43),
('Sitemap XML Dateien komprimieren?', 'SITEMAPXML_COMPRESS', 'Sollen die Sitemaps komprimiert werden?', 43),
('Sitemap XML Version', 'SITEMAPXML_VERSION', 'Read only Einstellung. Zeigt die aktuell installierte Version dieses Moduls', 43),
('Verzeichnis für Sitemaps', 'SITEMAPXML_DIR_WS', 'Unterverzeichnis in das die Untersitemaps gelegt werden sollen. Voreinstellung sitemap<br/>Wird hier leer gelassen werden sämtliche Sitemaps ins Shopverzeichnis gelegt.', 43),
('Name für Sitemap Index XML Datei', 'SITEMAPXML_SITEMAPINDEX', 'Sitemap XML Index Dateiname. Voreinstellung sitemap.<br/>Diese Datei wird den Suchmaschinen angegeben.', 43),
('News Box Manager - Änderungshäufigkeit', 'SITEMAPXML_BOXNEWS_CHANGEFREQ','Wie oft ändern sich die News Box Manager Beiträge normalerweise?<br/>Voreinstellung weekly = wöchentlich', 43)");


// delete old configuration/tools menu
$admin_page = 'configSitemapXML';
$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
$admin_page_tools = 'toolsSiteMapXML';
$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page_tools . "' LIMIT 1;");
// add configuration/tools menu
if (!zen_page_key_exists($admin_page)) {
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'Sitemap XML'
LIMIT 1;");
$db->Execute("INSERT IGNORE INTO " . TABLE_ADMIN_PAGES . " (page_key,language_key,main_page,page_params,menu_key,display_on_menu,sort_order) VALUES 
('configSitemapXML','BOX_CONFIGURATION_SITEMAPXML','FILENAME_CONFIGURATION',CONCAT('gID=',@gid),'configuration','Y',@gid)");
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'Sitemap XML'
LIMIT 1;");
$db->Execute("INSERT IGNORE INTO " . TABLE_ADMIN_PAGES . " (page_key,language_key,main_page,page_params,menu_key,display_on_menu,sort_order) VALUES 
('toolsSiteMapXML','BOX_SITEMAPXML','FILENAME_SITEMAPXML','','tools','Y',101)");
$messageStack->add('Sitemap XML erfolgreich installiert.', 'success');  
}