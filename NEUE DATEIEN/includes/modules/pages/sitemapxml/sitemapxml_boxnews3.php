<?php
/**
 * Part of the News Box Manager plugin, re-structured for Zen Cart v1.5.6 and later by lat9.
 * Copyright (C) 2015-2022, Vinos de Frutas Tropicales
 * Do Not Remove: Coded for Zen-Cart by geeks4u.com
 * Dedicated to Memory of Amelita "Emmy" Abordo Gelarderes
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml_boxnews3.php 2022-06-07 07:35:16Z webchills $
 */
 
// -----
// If the plugin's article filename isn't defined, nothing to be done.
//
if (!defined('FILENAME_ARTICLE')) {
    return;
}

echo '<h3>' . TEXT_HEAD_BOXNEWS . '</h3>';
$last_date = $db->Execute(
    "SELECT MAX(GREATEST(n.news_added_date, IFNULL(n.news_modified_date, '0001-01-01 00:00:00'))) AS last_date
       FROM " . TABLE_BOX_NEWS . " n
      WHERE n.news_status = 1
        AND NOW() BETWEEN n.news_start_date AND n.news_end_date
      ORDER BY last_date ASC"
);
$table_status = $db->Execute("SHOW TABLE STATUS LIKE '" . TABLE_BOX_NEWS . "'");
$last_date = max($table_status->fields['Update_time'], $last_date->fields['last_date']);
if ($sitemapXML->SitemapOpen('boxnews', $last_date)) {
    $news = $db->Execute(
        "SELECT n.box_news_id, GREATEST(n.news_added_date, IFNULL(n.news_modified_date, '0001-01-01 00:00:00')) AS last_date, nc.languages_id AS language_id
           FROM " . TABLE_BOX_NEWS . " n
                LEFT JOIN " . TABLE_BOX_NEWS_CONTENT . " nc ON (n.box_news_id = nc.box_news_id)
          WHERE nc.languages_id IN (" . $sitemapXML->getLanguagesIDs() . ")
            AND n.news_status = 1
            AND (n.news_end_date IS NULL OR NOW() BETWEEN n.news_start_date AND n.news_end_date)
            AND nc.news_title != ''" .
          (SITEMAPXML_BOXNEWS_ORDERBY != '' ? "ORDER BY " . SITEMAPXML_BOXNEWS_ORDERBY : ''));
    $sitemapXML->SitemapSetMaxItems($news->RecordCount());
    while (!$news->EOF) {
        $sitemapXML->writeItem(FILENAME_ARTICLE, 'p=' . $news->fields['box_news_id'], $news->fields['language_id'], $news->fields['last_date'], SITEMAPXML_BOXNEWS_CHANGEFREQ);
        $news->MoveNext();
    }
    $sitemapXML->SitemapClose();
}
unset($news);