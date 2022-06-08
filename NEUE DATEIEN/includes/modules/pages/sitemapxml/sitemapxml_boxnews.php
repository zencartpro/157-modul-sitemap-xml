<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml_boxnews.php 2022-06-08 20:37:16Z webchills $
 */

if ($sitemapXML->dbTableExist('TABLE_BOX_NEWS') && $sitemapXML->dbTableExist('TABLE_BOX_NEWS_CONTENT')) {

  echo '<h3>' . TEXT_HEAD_BOXNEWS . '</h3>';
  $last_date = $db->Execute("SELECT MAX(GREATEST(n.news_added_date, IFNULL(n.news_modified_date, '0001-01-01 00:00:00'), n.news_published_date)) AS last_date
                             FROM " . TABLE_BOX_NEWS . " n
                             WHERE n.news_status = 1
                               AND NOW() BETWEEN n.news_start_date AND n.news_end_date");
  $table_status = $db->Execute("SHOW TABLE STATUS LIKE '" . TABLE_BOX_NEWS . "'");
  $last_date = max($table_status->fields['Update_time'], $last_date->fields['last_date']);
  if ($sitemapXML->SitemapOpen('boxnews', $last_date)) {
    $news = $db->Execute("SELECT n.box_news_id, GREATEST(n.news_added_date, IFNULL(n.news_modified_date, '0001-01-01 00:00:00'), n.news_published_date) AS last_date, nc.languages_id AS language_id
                          FROM " . TABLE_BOX_NEWS . " n
                            LEFT JOIN " . TABLE_BOX_NEWS_CONTENT . " nc ON (n.box_news_id = nc.box_news_id)
                          WHERE nc.languages_id IN (" . $sitemapXML->getLanguagesIDs() . ")
                            AND n.news_status = 1
                            AND NOW() BETWEEN n.news_start_date AND n.news_end_date
                            AND nc.news_title != ''" .
                          (SITEMAPXML_BOXNEWS_ORDERBY != '' ? "ORDER BY " . SITEMAPXML_BOXNEWS_ORDERBY : ''));
    $sitemapXML->SitemapSetMaxItems($news->RecordCount());
    while (!$news->EOF) {
      $sitemapXML->writeItem(FILENAME_MORE_NEWS, 'news_id=' . $news->fields['box_news_id'], $news->fields['language_id'], $news->fields['last_date'], SITEMAPXML_BOXNEWS_CHANGEFREQ);
      $news->MoveNext();
    }
    $sitemapXML->SitemapClose();
    unset($news);
  }
}