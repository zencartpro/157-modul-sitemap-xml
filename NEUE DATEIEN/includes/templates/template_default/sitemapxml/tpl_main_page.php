<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: tpl_main_page.php 2022-06-08 20:37:16Z webchills $
 */
?>
<body id="sitemapxmlBody">
  <div id="mainWrapper">
    <div class="centerColumn" id="siteMapXML">
      <h1 id="siteMapXMLHeading"><?php echo HEADING_TITLE; ?></h1>
      <?php
      if ($genxml) {
        foreach ($SiteMapXMLmodules as $module) {
          $sitemapXML->SitemapClose();
          include($module);
        }
      }
      $sitemapXML->GenerateSitemapIndex();

      $time_start = explode(' ', PAGE_PARSE_START_TIME);
      $time_end = explode(' ', microtime());
      $parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
      ?>
      <div><?php echo sprintf(TEXT_EXECUTION_TIME, $sitemapXML->timefmt($parse_time), $db->queryCount(), number_format($db->queryTime(), 3)); ?></div>
    </div>
  </div>
  <script type="text/javascript">if (window.opener) window.opener.location.reload(true);</script>
</body>