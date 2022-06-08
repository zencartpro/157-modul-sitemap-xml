<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: config.sitemapxml.php 2022-06-08 20:37:16Z webchills $
 */
 
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
} 

$autoLoadConfig[999][] = array(
  'autoType' => 'init_script',
  'loadFile' => 'init_sitemapxml.php'
);