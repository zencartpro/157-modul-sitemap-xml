<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml_ezpages.php 2024-02-19 15:29:16Z webchills $
 */

echo '<h3>' . TEXT_HEAD_EZPAGES . '</h3>';
$select = '';
$from = '';
$where = '';
$order_by = '';
if (SITEMAPXML_EZPAGES_ORDERBY !== '') {
    $order_by = SITEMAPXML_EZPAGES_ORDERBY;
}

if ($sitemapXML->dbColumnExist(TABLE_EZPAGES, 'status_meta_robots') === true) {
    $where .= " AND status_meta_robots = 1";
} elseif ($sitemapXML->dbColumnExist(TABLE_EZPAGES, 'status_rel_nofollow')) {
    $where .= " AND status_rel_nofollow != 1";
}

if ($sitemapXML->dbTableExist('TABLE_EZPAGES_TEXT') === true) {
    $from .= " INNER JOIN " . TABLE_EZPAGES_TEXT . " pt ON p.pages_id = pt.pages_id";
    if ($sitemapXML->dbColumnExist(TABLE_EZPAGES_TEXT, 'language_id') === true) {
        $where .= " AND pt.language_id IN (" . $sitemapXML->getLanguagesIDs() . ") ";
    } elseif ($sitemapXML->dbColumnExist(TABLE_EZPAGES_TEXT, 'languages_id') === true) {
        $select .= ', pt.languages_id as language_id';
        $where .= " AND pt.languages_id IN (" . $sitemapXML->getLanguagesIDs() . ") ";
    }
}

$last_date = 0;
if ($sitemapXML->dbColumnExist(TABLE_EZPAGES, 'date_added') && $sitemapXML->dbColumnExist(TABLE_EZPAGES, 'last_modified')) {
    $select .= ", GREATEST(IFNULL(p.date_added, '0001-01-01 00:00:00'), IFNULL(p.last_modified, '0001-01-01 00:00:00')) AS last_date";
    if ($order_by !== '') {
        $order_by .= ', ';
    }
    $order_by .= "last_date DESC";
    $last_date_sql =
        "SELECT MAX(GREATEST(IFNULL(p.date_added, '0001-01-01 00:00:00'), IFNULL(p.last_modified, '0001-01-01 00:00:00'))) AS last_date
           FROM " . TABLE_EZPAGES . " p " . $from . "
          WHERE alt_url_external = ''" . $where;
    $last_date = $db->Execute($last_date_sql);
    $table_status = $db->Execute("SHOW TABLE STATUS LIKE '" . TABLE_EZPAGES . "'");
    $last_date = max($table_status->fields['Update_time'], $last_date->fields['last_date']);
    if ($last_date <= '0001-01-01 00:00:00') {
        $last_date = 0;
    }
}

if ($sitemapXML->SitemapOpen('ezpages', $last_date)) {
    $page_query_sql =
        "SELECT p.toc_chapter
           FROM " . TABLE_EZPAGES . " p " . $from . "
          WHERE alt_url_external = ''
            AND (
                (status_header = 1 AND header_sort_order > 0)
                 OR (status_sidebox = 1 AND sidebox_sort_order > 0)
                 OR (status_footer = 1 AND footer_sort_order > 0)
                )
           AND status_toc != 0" .
           $where . "
         GROUP BY toc_chapter";
    $page_query = $db->Execute($page_query_sql); // pages_id
    $toc_chapter_array = [];
    foreach ($page_query as $next_chapter) {
        $toc_chapter_array[$next_chapter['toc_chapter']] = $next_chapter['toc_chapter'];

    }
    $where_toc = ($toc_chapter_array !== []) ? (" OR toc_chapter IN (" . implode(',', $toc_chapter_array) . ")") : '';
    $page_query_sql =
        "SELECT *" . $select . "
           FROM " . TABLE_EZPAGES . " p " . $from . "
          WHERE alt_url_external = ''
            AND (
                (status_header = 1 AND header_sort_order > 0)
                OR (status_sidebox = 1 AND sidebox_sort_order > 0)
                OR (status_footer = 1 AND footer_sort_order > 0) " .
                $where_toc . "
                )" .
            $where . (($order_by !== '') ? " ORDER BY $order_by" : '');
    $page_query = $db->Execute($page_query_sql); // pages_id
    $sitemapXML->SitemapSetMaxItems($page_query->RecordCount());
    foreach ($page_query as $ez_page) {
        if ($ez_page['alt_url'] === '') { // internal link
            $link = FILENAME_EZPAGES;
            $linkParm = 'id=' . $ez_page['pages_id'] . ($ez_page['toc_chapter'] > 0 ? '&chapter=' . $ez_page['toc_chapter'] : '');
        } else {
            $link = (substr($ez_page['alt_url'], 0, 4) == 'http') ?
                $ez_page['alt_url'] :
                zen_href_link($ez_page['alt_url'], '', ($ez_page['page_is_ssl'] === '0' ? 'NONSSL' : 'SSL'), false, true, true);
            $link = str_replace('&amp;', '&', $link);
            $link = preg_replace('/&&+/', '&', $link);
            $link = preg_replace('/&/', '&amp;', $link);
            $linkParm = '';
            $parse_url = parse_url($link);
            if (!isset($parse_url['path'])) {
                $parse_url['path'] = '/';
            }
            $link_base_url = $parse_url['scheme'] . '://' . $parse_url['host'];
            if ($link_base_url !== HTTP_SERVER && $link_base_url !== HTTPS_SERVER) {
                echo sprintf(TEXT_ERRROR_EZPAGES_OUTOFBASE, $ez_page['alt_url'], $link) . '<br>';
                $link = false;
            } elseif (basename($parse_url['path']) === 'index.php') {
                $query_string = explode('&amp;', $parse_url['query']);
                foreach ($query_string as $query) {
                    list($parm_name, $parm_value) = explode('=', $query);
                    if ($parm_name === 'main_page') {
                        if ($parm_value === 'down_for_maintenance' || (defined('ROBOTS_PAGES_TO_SKIP') && in_array($parm_value, explode(',', ROBOTS_PAGES_TO_SKIP)))) {
                            echo sprintf(TEXT_ERRROR_EZPAGES_ROBOTS, $ez_page['alt_url'], $link) . '<br>';
                            $link = false;
                            break;
                        }
                    }
                }
            }
        }

        if ($link !== false) {
            $last_date = (!empty($ez_page['last_date']) && $ez_page['last_date'] > '0001-01-01 00:00:00') ? $ez_page['last_date'] : '';
            $ez_page['language_id'] = $ez_page['language_id'] ?? 0;
            $sitemapXML->writeItem($link, $linkParm, $ez_page['language_id'], $last_date, SITEMAPXML_EZPAGES_CHANGEFREQ);
        }
    }

    $sitemapXML->SitemapClose();
    unset($page_query);
}
