##################################################################################
# UNINSTALL Sitemap XML 4.2.0 - 2024-02-25 - webchills
# UNINSTALL - NUR AUSFÜHREN WENN SIE DAS MODUL KOMPLETT ENTFERNEN WOLLEN!
##################################################################################

SET @gid=0;
SELECT @gid:=configuration_group_id
FROM configuration_group
WHERE configuration_group_title = 'Sitemap XML' LIMIT 1;
DELETE FROM configuration WHERE configuration_group_id = @gid;
DELETE FROM configuration_group WHERE configuration_group_id = @gid;
DELETE FROM configuration_language WHERE configuration_key LIKE '%SITEMAPXML%';
DELETE FROM admin_pages WHERE page_key='toolsSiteMapXML';
DELETE FROM admin_pages WHERE page_key='configSitemapXML';