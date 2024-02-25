<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml.php 2024-02-25 19:37:16Z webchills $
 */
 
define('HEADING_TITLE', 'Sitemap XML');
define('TEXT_SITEMAPXML_TIPS_HEAD', 'Tips');
define('TEXT_SITEMAPXML_INSTRUCTIONS_HEAD', 'Create / update your site map(s)');
define('TEXT_SITEMAPXML_CHOOSE_PARAMETERS_REBUILD', 'Rebuild all sitemap*.xml files!');
define('ERROR_SITEMAPXML_TOKEN_INVALID_HDR', 'Sitemaps cannot be created');
define('ERROR_SITEMAPXML_TOKEN_INVALID_MESSAGE', 'The execution-token (%1$s) you supplied contains invalid characters.');

define('TEXT_SITEMAPXML_ROBOTS_HDR','Your Site\'s <code>robots.txt</code> File');
define('SUCCESS_SITEMAPXML_ROBOTS_TXT_OK','Your site\'s <code>robots.txt</code> is pointing search engines to your <code>%1$s</code> Sitemap XML!');
define('WARNING_SITEMAPXML_NO_ROBOTS_FILE','Your site is missing its <code>robots.txt</code> file! Search engines will not be able to find your sitemap.');
define('WARNING_SITEMAPXML_NO_ROBOTS_TEXT','Your site\'s <code>robots.txt</code> file does not point search engines to your Sitemap XML file. Consider adding <code>Sitemap: %1$s</code> to your robots.txt file.');

define('TEXT_SITEMAPXML_PLUGINS_LIST', 'Sitemap Plugins');
define('TEXT_SITEMAPXML_PLUGINS_LIST_SELECT', 'Select Sitemaps to Generate');

define('TEXT_SITEMAPXML_FILE_LIST', 'Sitemaps File List');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_FNAME', 'Name');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_FSIZE', 'Size');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_FTIME', 'Last modified');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_FPERMS', 'Permissions');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_TYPE', 'Type');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_ITEMS', 'Items');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_COMMENTS', 'Comments');
define('TEXT_SITEMAPXML_FILE_LIST_TABLE_ACTION', 'Action');

define('TEXT_SITEMAPXML_IMAGE_POPUP_ALT', 'open sitemap in new window');
define('TEXT_SITEMAPXML_RELOAD_WINDOW', 'Refresh File List');

define('TEXT_SITEMAPXML_FILE_LIST_COMMENTS_READONLY', 'Read Only!!!');
define('TEXT_SITEMAPXML_FILE_LIST_COMMENTS_IGNORED', 'Ignored');

define('TEXT_SITEMAPXML_FILE_LIST_TYPE_URLSET', 'UrlSet');
define('TEXT_SITEMAPXML_FILE_LIST_TYPE_SITEMAPINDEX', 'SitemapIndex');
define('TEXT_SITEMAPXML_FILE_LIST_TYPE_UNDEFINED', 'Undefined!!!');

define('TEXT_ACTION_VIEW_FILE', 'View');
define('TEXT_ACTION_TRUNCATE_FILE', 'Truncate');
define('TEXT_ACTION_TRUNCATE_FILE_CONFIRM', 'You really want to truncate the file %s?');
define('TEXT_ACTION_DELETE_FILE', 'Delete');
define('TEXT_ACTION_DELETE_FILE_CONFIRM', 'You really want to delete the file %s?');

define('TEXT_MESSAGE_FILE_ERROR_OPENED', 'Error opening file %s');
define('TEXT_MESSAGE_FILE_TRUNCATED', 'File %s truncated');
define('TEXT_MESSAGE_FILE_DELETED', 'File %s deleted');
define('TEXT_MESSAGE_FILE_ERROR_DELETED', 'Error deleted file %s');

define('TEXT_SITEMAPXML_TIPS_TEXT', '<p>You can read all about sitemaps at <strong><a href="https://sitemaps.org/" target="_blank" rel="noopener noreferrer" class="splitPageLink">[Sitemaps.org]</a></strong>.</p>
        <p>Once the sitemaps are generated, you need to get them noticed:</p>
        <ol>
            <li>Register or login to your account: <strong><a href="https://www.google.com/webmasters/tools/home" target="_blank" rel="noopener noreferrer" class="splitPageLink">[Google]</a></strong>, <strong><a href="https://ssl.bing.com/webmaster" target="_blank" rel="noopener noreferrer" class="splitPageLink">[Bing]</a></strong>.</li>
            <li>Submit your Sitemap, e.g. <code>https://mystore.com/sitemap.xml</code> via the search engine\'s submission interface <strong><a href="https://www.google.com/webmasters/tools/home" target="_blank" rel="noopener noreferrer" class="splitPageLink">[Google]</a></strong>.</li>
            <li>Specify the Sitemap location in your <a href="' . HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'robots.txt' . '" target="_blank" class="splitPageLink">robots.txt</a> file (<a href="https://sitemaps.org/protocol.php#submit_robots" target="_blank" rel="noopener noreferrer" class="splitPageLink">more...</a>): <code>Sitemap: https://mystore.com/sitemap.xml</code></li>
        </ol>
        <p>To <em>automatically</em> update sitemaps, you will need to set up a Cron job via your host\'s control panel.</p>
        <p>To run the generation as a cron job (at 5am for example), you will need to create something similar to the following examples.</p>
        <samp>0 5 * * * GET \'https://your_domain/index.php?main_page=sitemapxml&amp;rebuild=yes%1$s\'</samp><br>
        <samp>0 5 * * * wget -q \'https://your_domain/index.php?main_page=sitemapxml&amp;rebuild=yes%1$s\' -O /dev/null</samp><br>
        <samp>0 5 * * * curl -s \'https://your_domain/index.php?main_page=sitemapxml&amp;rebuild=yes%1$s\'</samp><br>
        <samp>0 5 * * * php -f &lt;path to shop&gt;/cgi-bin/sitemapxml.php rebuild=yes%2$s</samp><br>');

