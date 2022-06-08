<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml_mainpage.php 2022-06-08 20:37:16Z webchills $
 */

echo '<h3>' . TEXT_HEAD_MAINPAGE . '</h3>';
if ($sitemapXML->SitemapOpen('mainpage')) {
  $languages = $db->Execute("SELECT *
                             FROM " . TABLE_LANGUAGES . " l
                             WHERE l.languages_id IN (" . $sitemapXML->getLanguagesIDs() . ") " .
                             (SITEMAPXML_HOMEPAGE_ORDERBY != '' ? "ORDER BY " . SITEMAPXML_HOMEPAGE_ORDERBY : ''));
  $sitemapXML->SitemapSetMaxItems($languages->RecordCount());
  while (!$languages->EOF) {
    $sitemapXML->writeItem(FILENAME_DEFAULT, '', $languages->fields['languages_id'], '', SITEMAPXML_HOMEPAGE_CHANGEFREQ);
    $languages->MoveNext();
  }
  $sitemapXML->SitemapClose();
  unset($languages);
}