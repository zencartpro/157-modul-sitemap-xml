<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml_reviews.php 2022-06-08 20:37:16Z webchills $
 */

echo '<h3>' . TEXT_HEAD_REVIEWS . '</h3>';
$last_date = $db->Execute("SELECT MAX(GREATEST(r.date_added, IFNULL(r.last_modified, '0001-01-01 00:00:00'))) AS last_date
                           FROM " . TABLE_REVIEWS . " r
                           WHERE r.status = '1'");
$table_status = $db->Execute("SHOW TABLE STATUS LIKE '" . TABLE_REVIEWS . "'");
$last_date = max($table_status->fields['Update_time'], $last_date->fields['last_date']);
if ($sitemapXML->SitemapOpen('reviews', $last_date)) {
  $reviews = $db->Execute("SELECT r.reviews_id, GREATEST(r.date_added, IFNULL(r.last_modified, '0001-01-01 00:00:00')) AS last_date, r.products_id, r.reviews_rating AS priority, rd.languages_id AS language_id
                         FROM " . TABLE_REVIEWS . " r
                           LEFT JOIN " . TABLE_REVIEWS_DESCRIPTION . " rd ON (r.reviews_id = rd.reviews_id)
                         WHERE r.status = '1'
                           AND rd.languages_id IN (" . $sitemapXML->getLanguagesIDs() . ") " .
                         (SITEMAPXML_REVIEWS_ORDERBY != '' ? "ORDER BY " . SITEMAPXML_REVIEWS_ORDERBY : ''));
  $sitemapXML->SitemapSetMaxItems($reviews->RecordCount());
  while (!$reviews->EOF) {
    $sitemapXML->writeItem(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews->fields['products_id'] . '&reviews_id=' . $reviews->fields['reviews_id'], $reviews->fields['language_id'], $reviews->fields['last_date'], SITEMAPXML_REVIEWS_CHANGEFREQ);
    $reviews->MoveNext();
  }
  $sitemapXML->SitemapClose();
  unset($reviews);
}