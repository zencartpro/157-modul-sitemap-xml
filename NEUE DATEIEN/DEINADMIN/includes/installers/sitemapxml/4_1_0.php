<?php
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'Sitemap XML'
LIMIT 1;");
$db->Execute("INSERT IGNORE INTO ".TABLE_CONFIGURATION." (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, last_modified, use_function, set_function) VALUES
('Category paging', 'SITEMAPXML_CATEGORIES_PAGING', 'false', 'Add all category pages (with page=) to sitemap', @gid, 26, now(), now(), '', 'zen_cfg_select_option(array(\'true\', \'false\'),')");
$db->Execute("REPLACE INTO ".TABLE_CONFIGURATION_LANGUAGE." (configuration_title, configuration_key, configuration_description, configuration_language_id) VALUES
('Kategorien - Seitenaufteilung', 'SITEMAPXML_CATEGORIES_PAGING', 'Soll die Kategoriesitemap auf mehrere Seiten aufgeteilt werden, wenn Sie sher viele Kategorien enthält (mit page=)', 43)");
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '4.1.0' WHERE configuration_key = 'SITEMAPXML_VERSION' LIMIT 1;");