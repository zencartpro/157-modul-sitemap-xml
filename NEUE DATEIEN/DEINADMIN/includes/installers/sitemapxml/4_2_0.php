<?php
$db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SITEMAPXML_PING_URLS';");
$db->Execute("DELETE FROM " . TABLE_CONFIGURATION_LANGUAGE . " WHERE configuration_key = 'SITEMAPXML_PING_URLS';");
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '4.2.0' WHERE configuration_key = 'SITEMAPXML_VERSION' LIMIT 1;");