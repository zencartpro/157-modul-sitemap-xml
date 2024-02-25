<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: header_php.php 2024-02-19 15:37:16Z webchills $
 */

//@ini_set('display_errors', '1');
//error_reporting(E_ALL);
set_time_limit(0);

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_SITEMAPXML');

/**
 * load the site map class
 */
require DIR_WS_CLASSES . 'sitemapxml.php';

/**
 * load language files
 */
require DIR_WS_MODULES . zen_get_module_directory('require_languages.php');
$breadcrumb->add(NAVBAR_TITLE);

$inline = (isset($_GET['inline']) && $_GET['inline'] === 'yes');
$genxml  = (!isset($_GET['genxml']) || $_GET['genxml'] !== 'no');
$checkurl = (isset($_GET['checkurl']) && $_GET['checkurl'] === 'yes');
$rebuild = (isset($_GET['rebuild']) && $_GET['rebuild'] === 'yes');

if (SITEMAPXML_EXECUTION_TOKEN !== '' && (!isset($_GET['token']) || SITEMAPXML_EXECUTION_TOKEN !== $_GET['token'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo 'Incorrect Start Security Token';
    exit(0);
}

$sitemapXML = new zen_SiteMapXML($inline, $rebuild, $genxml);

$sitemapXML->setCheckURL($checkurl);

$tpl_dir = $template->get_template_dir('gss.xsl', DIR_WS_TEMPLATE, $current_page_base, 'css');
if (is_file($tpl_dir . '/gss.xsl')) {
    $sitemapXML->setStylesheet($tpl_dir . '/gss.xsl');
}

$SiteMapXMLmodules = [];
$SiteMapXMLmodules = glob(DIR_WS_MODULES . 'pages/' . $current_page_base . '/sitemapxml_*.php');

$pluginsFilesActive = explode(';', SITEMAPXML_PLUGINS);
$temp = [];
foreach ($SiteMapXMLmodules as $pluginFile) {
    if (in_array(basename($pluginFile), $pluginsFilesActive)) {
        $temp[] = $pluginFile;
    }
}
$SiteMapXMLmodules = $temp;

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_SITEMAPXML');
