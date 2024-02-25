<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml_news.php 2024-02-19 15:30:16Z webchills $
 */

if ($sitemapXML->dbTableExist('TABLE_NEWS_ARTICLES') === false) {
    return;
}

echo '<h3>' . TEXT_HEAD_NEWS_ARTICLES . '</h3>';
$last_date = $db->Execute(
    "SELECT MAX(GREATEST(n.news_date_added, IFNULL(n.news_last_modified, '0001-01-01 00:00:00'), n.news_date_published)) AS last_date
       FROM " . TABLE_NEWS_ARTICLES . " n
      WHERE n.news_status = 1
        AND n.news_date_published <= NOW()"
);
$table_status = $db->Execute("SHOW TABLE STATUS LIKE '" . TABLE_NEWS_ARTICLES . "'");
$last_date = max($table_status->fields['Update_time'], $last_date->fields['last_date']);
if ($sitemapXML->SitemapOpen('newsarticles', $last_date)) {
    $news = $db->Execute(
        "SELECT n.article_id, GREATEST(n.news_date_added, IFNULL(n.news_last_modified, '0001-01-01 00:00:00'), n.news_date_published) AS last_date, nt.language_id AS language_id
           FROM " . TABLE_NEWS_ARTICLES . " n
                INNER JOIN " . TABLE_NEWS_ARTICLES_TEXT . " nt
                    ON n.article_id = nt.article_id
                   AND nt.news_article_text != ''
          WHERE n.news_status = 1
            AND n.news_date_published <= NOW()" .
          (SITEMAPXML_NEWS_ORDERBY !== '' ? ' ORDER BY ' . SITEMAPXML_NEWS_ORDERBY : '')
    );
    $sitemapXML->SitemapSetMaxItems($news->RecordCount());
    foreach ($news as $next_item) {
        $sitemapXML->writeItem(FILENAME_NEWS_ARTICLE, 'article_id=' . $next_item['article_id'], $next_item['language_id'], $next_item['last_date'], SITEMAPXML_NEWS_CHANGEFREQ);
    }

    $sitemapXML->SitemapClose();
    unset($news);
}

// -----
// Keeping this for now, since I'm not sure what the difference is!
//
if (false) {
    echo '<h3>' . TEXT_HEAD_NEWS . '</h3>';
    if ($sitemapXML->SitemapOpen('news', $last_date)) {
      $news = $db->Execute("SELECT news_date_published
                            FROM " . TABLE_NEWS_ARTICLES . "
                            WHERE news_status = '1'
                              AND news_date_published <= NOW()
                            GROUP BY news_date_published DESC");
      $sitemapXML->SitemapSetMaxItems($news->RecordCount());
      $link_ym_array = array();
      while (!$news->EOF) {
        $date_ymd = substr($news->fields['news_date_published'], 0, 10);
        $date_ym  = substr($news->fields['news_date_published'], 0, 7);
        if (!isset($link_ym_array[$date_ym])) {
          $sitemapXML->writeItem(FILENAME_NEWS_INDEX, 'date=' . $date_ym, 0, $date_ym, SITEMAPXML_NEWS_CHANGEFREQ);
          $link_ym_array[$date_ym] = true;
        }
        $sitemapXML->writeItem(FILENAME_NEWS_INDEX, 'date=' . $date_ymd, 0, $date_ymd, SITEMAPXML_NEWS_CHANGEFREQ);
        $news->MoveNext();
      }
      $sitemapXML->SitemapClose();
      unset($news);
    }
}
