<?php
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '4.1.2' WHERE configuration_key = 'SITEMAPXML_VERSION' LIMIT 1;");