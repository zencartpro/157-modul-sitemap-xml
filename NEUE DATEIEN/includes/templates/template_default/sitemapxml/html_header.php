<?php
/**
 * package Sitemap XML
 * @copyright Copyright 2005-2016 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: html_header.php 2022-06-08 20:37:16Z webchills $
 */
 
if (is_file(DIR_WS_CLASSES . 'Mobile_Detect.php')) {
  if (!class_exists('Mobile_Detect')) {
    include_once(DIR_WS_CLASSES . 'Mobile_Detect.php');
  }
  $detect = new Mobile_Detect;
  $isMobile = $detect->isMobile();
  $isTablet = $detect->isTablet();
  if (!isset($layoutType)) $layoutType = ($isMobile ? ($isTablet ? 'tablet' : 'mobile') : 'default');
}

?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo HEADING_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<?php if (defined('FAVICON')) { ?>
<link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<?php } //endif FAVICON ?>

<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>" />
<style>
body {
  font-family: Verdana, Geneva, sans-serif;
  font-size: small;
  }
</style>
</head>
<?php // NOTE: Blank line following is intended: ?>

