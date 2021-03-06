<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sitemapxml_video_products.php 2022-06-08 20:37:16Z webchills $
 */
 
@define('SITEMAPXML_VIDEO_FAMILY_FRIENDLY', 'yes'); // yes no
@define('SITEMAPXML_VIDEO_THUMBNAIL_SIZE', 'medium'); // small medium large
@define('SITEMAPXML_VIDEO_PLAYER', 'player.swf?file=/%s');
@define('SITEMAPXML_VIDEO_DESCRIPTION_MAXSIZE', '300');

if (function_exists('zen_get_products_video_file')) {
  echo '<h3>' . TEXT_HEAD_PRODUCTS_VIDEO . '</h3>';
  $file_main_product_image = DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE);
  $last_date = 0;
  if ($zen_SiteMapXML->SitemapOpen('products', $last_date, 'video')) {
    $products = $db->Execute("SELECT p.products_id, p.products_image,
                                     pd.products_name, pd.products_description, pd.language_id,
                                     pm.metatags_title, pm.metatags_keywords, pm.metatags_description
                              FROM " . TABLE_PRODUCTS . " p
                                LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON (p.products_id = pd.products_id)
                                LEFT JOIN " . TABLE_META_TAGS_PRODUCTS_DESCRIPTION . " pm ON (p.products_id = pm.products_id AND pd.language_id = pm.language_id)
                              WHERE p.products_status = '1'
                                AND pd.language_id IN (" . $zen_SiteMapXML->getLanguagesIDs() . ") ");
  
    $zen_SiteMapXML->SitemapSetMaxItems(0);
    while (!$products->EOF) {
      $langParm = $zen_SiteMapXML->getLanguageParameter($products->fields['language_id']);
      if ($langParm !== false) {
        if ($videoFile = zen_get_products_video_file($products->fields['products_id'], $zen_SiteMapXML->getLanguageDirectory($products->fields['language_id']))) {

          $link = zen_href_link(zen_get_info_page($products->fields['products_id']), 'products_id=' . $products->fields['products_id'] . $langParm, 'NONSSL', false);

          $videoContentLoc = DIR_WS_VIDEOS . $videoFile;
          $videoPlayerLoc = sprintf(SITEMAPXML_VIDEO_PLAYER, $videoContentLoc);
          $products_image = $products->fields['products_image'];
          include($file_main_product_image);
          switch (SITEMAPXML_VIDEO_THUMBNAIL_SIZE) {
            case 'small':
              $img = zen_image(DIR_WS_IMAGES . $products_image, '', SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
              break;
            case 'medium':
              $img = zen_image($products_image_medium, '', MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT);
              break;
            case 'large':
            default:
              $img = zen_image($products_image_large, '', MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT);
              break;
          }
          if (preg_match('@src="([^"]*)"@', $img, $match)) {
            $videoThumbnailLoc = $zen_SiteMapXML->_clear_url($match[1]); // http://www.usim.co.il/images/thumbnails/nokia/nokia_5800-450x300.jpg
          } else {
            $videoThumbnailLoc = '';
          }

          if ($products->fields['metatags_title'] != null && $products->fields['metatags_title'] != '') {
            $videoTitle = $products->fields['metatags_title'];
          } else {
            $videoTitle = strip_tags($products->fields['products_name']);
          }

          if (strlen($videoTitle) > 100) {
            $videoTitle = zen_trunc_string($videoTitle, 100, false);

          }

          if ($products->fields['metatags_description'] != null && $products->fields['metatags_description'] != '') {
            $videoDescription = $products->fields['metatags_description'];
          } else {
          	$videoDescription = strip_tags($products->fields['products_description']);
          }

          if (strlen($videoDescription) > SITEMAPXML_VIDEO_DESCRIPTION_MAXSIZE) {
            $videoDescription = zen_trunc_string($videoDescription, SITEMAPXML_VIDEO_DESCRIPTION_MAXSIZE, false);

          }
          $videoTags = '';
          if ($products->fields['metatags_keywords'] != null && $products->fields['metatags_keywords'] != '') {
            $words = explode(',', $products->fields['metatags_keywords']);
            $n = min(sizeof($words), 32);
            for ($i=0;$i<$n;$i++) {
            	$videoTags .= '  <video:tag>' . '<![CDATA[ ' . $words[$i] . ' ]]>' . '</video:tag>' . "\n";
            }
          }
          $videoCategory = '';
          $videoCategory = '';

          if ($videoDuration = GetFLVDuration(DIR_FS_CATALOG . $videoContentLoc)) {
          	$videoDuration = intval($videoDuration/1000);
          }


          $videomapXML = '';
          $videomapXML .= '<video:video>' . "\n";
          $videomapXML .= '  <video:content_loc>' . HTTP_SERVER . DIR_WS_CATALOG . $videoContentLoc . '</video:content_loc>' . "\n";
          $videomapXML .= '  <video:player_loc allow_embed="yes">' . HTTP_SERVER . DIR_WS_CATALOG . $videoPlayerLoc . '</video:player_loc>' . "\n";
          if ($videoThumbnailLoc != '') {
            $videomapXML .= '  <video:thumbnail_loc>' . HTTP_SERVER . DIR_WS_CATALOG . $videoThumbnailLoc . '</video:thumbnail_loc>' . "\n";
          }
          $videomapXML .= '  <video:title>' . $videoTitle . '</video:title>' . "\n";
          $videomapXML .= '  <video:description>' . '<![CDATA[ ' . $videoDescription . ' ]]>' . '</video:description>' . "\n";
          $videomapXML .= $videoTags;
          if ($videoCategory != '') {
            $videomapXML .= '  <video:category>' . $videoCategory . '</video:category>' . "\n";
          }
          if ($videoDuration != '') {
            $videomapXML .= '  <video:duration>' . $videoDuration . '</video:duration>' . "\n";
          }
          $videomapXML .= '  <video:family_friendly>' . SITEMAPXML_VIDEO_FAMILY_FRIENDLY . '</video:family_friendly>' . "\n";
          $videomapXML .= '</video:video>' . "\n";

          $zen_SiteMapXML->SitemapWriteItem($link, '', '', $videomapXML);
        }
      }
      $products->MoveNext();
    }
    $zen_SiteMapXML->SitemapClose();
    unset($products);
  }
}