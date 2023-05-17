<?php
/**
 * Sitemap XML Feed
 *
 * @package Sitemap XML Feed
 * @copyright Copyright 2005-2018 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart-pro.at/license/2_0.txt GNU Public License V2.0
 * @version $Id: sitemapxml.php 2023-05-17 10:03:18 webchills $
 */

require('includes/application_top.php');

if (!is_file(DIR_WS_LANGUAGES . $_SESSION['language'] . '/sitemapxml.php')) {
  require_once(DIR_WS_LANGUAGES . 'german/sitemapxml.php');
  $messageStack->add(sprintf(TEXT_MESSAGE_LANGUGE_FILE_NOT_FOUND, $_SESSION['language']), 'warning');
}

$sql = "SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key='SITEMAPXML_VERSION'";
$version = $db->Execute($sql);
if (!$version->EOF) {
  define('SITEMAPXML_VERSION_CURRENT', $version->fields['configuration_value']);
}

$action = (isset($_POST['action']) ? $_POST['action'] : '');

if (zen_not_null($action)) {

  switch ($action) {    
    case 'view_file':
    case 'truncate_file':
    case 'delete_file':
      if (isset($_POST['file']) && trim($_POST['file']) != '' && (($ext = substr($_POST['file'], strpos($_POST['file'], '.'))) == '.xml' || $ext = '.xml.gz')) {
        $file = zen_db_prepare_input($_POST['file']);
        switch ($action) {
          case 'view_file':
            if ($fp = fopen(DIR_FS_CATALOG . $file, 'r')) {
              header('Content-Length: ' . filesize(DIR_FS_CATALOG . $file));
              header('Content-Type: text/plain; charset=' . CHARSET);
              while (!feof($fp)) {
                $contents = fread($fp, 8192);
                echo $contents;
              }
              fclose($fp);
              die();
            } else {
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_ERROR_OPENED, $file), 'error');
            }
            break;
          case 'truncate_file':
            if ($fp = fopen(DIR_FS_CATALOG . $file, 'w')) {
              fclose($fp);
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_TRUNCATED, $file), 'success');
            } else {
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_ERROR_OPENED, $file), 'error');
            }
            break;
          case 'delete_file':
            if (unlink(DIR_FS_CATALOG . $file)) {
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_DELETED, $file), 'success');
            } else {
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_ERROR_DELETED, $file), 'error');
            }
            break;
        }
      }
      zen_redirect(zen_href_link(FILENAME_SITEMAPXML));
      break;

    case 'select_plugins':
      $active_plugins = (isset($_POST['plugin']) ? $_POST['plugin'] : '');
      $active_plugins = (is_array($active_plugins) ? implode(';', $active_plugins) : $active_plugins);
      $sql = "UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . zen_db_input($active_plugins) . "' where configuration_key='SITEMAPXML_PLUGINS'";
      $db->Execute($sql);
      zen_redirect(zen_href_link(FILENAME_SITEMAPXML));
      break;
  }

}
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo HEADING_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<style type="text/css">
.index {
  font-weight: bold;
}
.zero {
  font-style: italic;
}
fieldset {
  border: 1px solid black;
  margin-top: 10px;
  padding: 10px;
}
fieldset legend{
  font-size: 16px;
  margin-bottom: 0;
}
fieldset {
  margin-right: 10px;
}
form#selectPlugins input.selected {
  font-weight: bold;
}
label {
  font-weight: normal;
}
.main a img {
  margin-bottom: 0;
}
.link_button {
  border: solid 1px #898989;
  background: #f2f2f2;
  color: #333333;
  padding: 5px 4px;
  margin: 10px 10px 10px 0;
  text-decoration: none;
}
.link_button:hover{
  background: #f2f2f2;
  border: solid 1px black;
  color: black;
  text-decoration: none;
}
#overviewTips {
  border-collapse: collapse;
  border: solid 1px black;
  padding: 10px;
  vertical-align: top;
}
label.plugin_active {
  font-weight: bold;
}
.right {
  text-align: right;
}
</style>
<script src="includes/menu.js"></script>
<script src="includes/general.js"></script>
<script>
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
</script>
<script>
function getFormFields(obj) {
  var getParms = "";
  for (var i=0; i<obj.childNodes.length; i++) {
    if (obj.childNodes[i].name == "securityToken") continue;
    if (obj.childNodes[i].tagName == "INPUT") {
      if (obj.childNodes[i].type == "text") {
        getParms += "&" + obj.childNodes[i].name + "=" + obj.childNodes[i].value;
      }
      if (obj.childNodes[i].type == "hidden") {
        getParms += "&" + obj.childNodes[i].name + "=" + obj.childNodes[i].value;
      }
      if (obj.childNodes[i].type == "checkbox") {
        if (obj.childNodes[i].checked) {
          getParms += "&" + obj.childNodes[i].name + "=" + obj.childNodes[i].value;
        }
      }
      if (obj.childNodes[i].type == "radio") {
        if (obj.childNodes[i].checked) {
          getParms += "&" + obj.childNodes[i].name + "=" + obj.childNodes[i].value;
        }
      }
    }
    if (obj.childNodes[i].tagName == "SELECT") {
      var sel = obj.childNodes[i];
      getParms += "&" + sel.name + "=" + sel.options[sel.selectedIndex].value;
    }
  }
  getParms = getParms.replace(/\s+/g," ");
  getParms = getParms.replace(/ /g, "+");
  return getParms;
}
</script>
</head>
<body onload="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table style="width:100%">
  <tr>
<!-- body_text //-->
    <td><table style="width:100%">
      <tr>
        <td><table style="width:100%">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading right"><?php echo (defined('SITEMAPXML_VERSION_CURRENT') ? ' v ' . SITEMAPXML_VERSION_CURRENT : ''); ?></td>
          </tr>
        </table></td>
      </tr>


<?php

  $start_parms = '';
  if (defined('SITEMAPXML_EXECUTION_TOKEN') && zen_not_null(SITEMAPXML_EXECUTION_TOKEN)) {
    $start_parms = 'token=' . SITEMAPXML_EXECUTION_TOKEN;
  }
?>
      <tr>
        <td>
          <table class="main">
            <tr>
              <td>
                <h3><?php echo TEXT_SITEMAPXML_INSTRUCTIONS_HEAD; ?></h3>
                <fieldset id="actions">
                  <legend><?php echo TEXT_SITEMAPXML_CHOOSE_PARAMETERS; ?></legend>
                  <?php echo zen_draw_form('pingSE', FILENAME_SITEMAPXML, '', 'post', 'id="pingSE" target="_blank" onsubmit="javascript:window.open(\'' .  zen_catalog_href_link(FILENAME_SITEMAPXML, $start_parms) . '\'+getFormFields(this), \'sitemapPing\', \'resizable=1,statusbar=5,width=860,height=800,top=0,left=0,scrollbars=yes,toolbar=yes\');return false;"'); ?>
                    <?php echo zen_draw_checkbox_field('rebuild', 'yes', false, '', 'id="rebuild"'); ?>
                    <label for="rebuild"><?php echo TEXT_SITEMAPXML_CHOOSE_PARAMETERS_REBUILD; ?></label>
                    <br class="clearBoth">
                    <?php echo zen_draw_checkbox_field('ping', 'yes', false, '', 'id="ping"'); ?>
                    <label for="ping"><?php echo TEXT_SITEMAPXML_CHOOSE_PARAMETERS_PING; ?></label>
                    <br class="clearBoth">
                    <?php echo '<button type="submit" title="' . zen_catalog_href_link(FILENAME_SITEMAPXML) . '">' . IMAGE_SEND . '</button>'; ?>
                  </form>
                </fieldset>
                <br class="clearBoth">
                <h3><?php echo TEXT_SITEMAPXML_PLUGINS_LIST; ?></h3>
                <div style="border: solid 1px; padding: 4px;">
                <fieldset id="plugins">
                  <legend><?php echo TEXT_SITEMAPXML_PLUGINS_LIST_SELECT; ?></legend>
<?php
echo zen_draw_form('selectPlugins', FILENAME_SITEMAPXML, '', 'post', 'id="selectPlugins"');
echo zen_draw_hidden_field('action', 'select_plugins');
if (!($plugins_files = glob(DIR_FS_CATALOG_MODULES . 'pages/sitemapxml/' . 'sitemapxml_*.php'))) $plugins_files = [];
$plugins_files_active = explode(';', SITEMAPXML_PLUGINS);
foreach ($plugins_files as $plugin_file) {
  $plugin_file = basename($plugin_file);
  $plugin_name = str_replace('.php', '', $plugin_file);
  $active = in_array($plugin_file, $plugins_files_active);
  echo zen_draw_checkbox_field('plugin[]', $plugin_file, $active, '', 'id="plugin-' . $plugin_name . '"');
?>
                  <label for="<?php echo 'plugin-' . $plugin_name . ''; ?>" class="plugin<?php echo ($active ? '_active' : ''); ?>"><?php echo $plugin_file; ?></label><br>
<?php } ?>
                    <br class="clearBoth">
                    <button type="submit"><?php echo IMAGE_SAVE; ?></button>
                  </form>
                </fieldset>
                <br class="clearBoth">
                <fieldset>
                  <legend><?php echo TEXT_SITEMAPXML_FILE_LIST; ?></legend>
                  <table style="width:100%">
                    <tr class="dataTableHeadingRow">
                      <th class="dataTableHeadingContent center"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_FNAME; ?></th>
                      <th class="dataTableHeadingContent center"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_FSIZE; ?></th>
                      <th class="dataTableHeadingContent center"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_FTIME; ?></th>
                      <th class="dataTableHeadingContent center"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_FPERMS; ?></th>
                      <th class="dataTableHeadingContent center"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_TYPE; ?></th>
                      <th class="dataTableHeadingContent center"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_ITEMS; ?></th>
                      <th class="dataTableHeadingContent center"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_COMMENTS; ?></th>
                      <th class="dataTableHeadingContent center"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_ACTION; ?></th>
                    </tr>
<?php
$indexFile = SITEMAPXML_SITEMAPINDEX . (SITEMAPXML_COMPRESS == 'true' ? '.xml.gz' : '.xml');
if (!($sitemapFiles = glob(DIR_FS_CATALOG . 'sitemap' . '*' . '.xml'))) $sitemapFiles = [];
if (!($sitemapFilesGZ = glob(DIR_FS_CATALOG . 'sitemap' . '*' . '.xml.gz'))) $sitemapFilesGZ = [];
$sitemapFiles = array_merge($sitemapFiles, $sitemapFilesGZ);
if (SITEMAPXML_DIR_WS != '') {
  $sitemapxml_dir_ws = SITEMAPXML_DIR_WS;
  $sitemapxml_dir_ws = trim($sitemapxml_dir_ws, '/');
  $sitemapxml_dir_ws .= '/';
  if (($files = glob(DIR_FS_CATALOG . $sitemapxml_dir_ws . 'sitemap' . '*' . '.xml'))) $sitemapFiles = array_merge($sitemapFiles, $files);
  if (($files = glob(DIR_FS_CATALOG . $sitemapxml_dir_ws . 'sitemap' . '*' . '.xml.gz'))) $sitemapFiles = array_merge($sitemapFiles, $files);
}
sort($sitemapFiles);
if (in_array(DIR_FS_CATALOG . $indexFile, $sitemapFiles)) {
  $sitemapFiles = array_merge(array(DIR_FS_CATALOG . $indexFile), $sitemapFiles);
}
$sitemapFiles = array_unique($sitemapFiles);
clearstatcache();
$l = strlen(DIR_FS_CATALOG);
foreach ($sitemapFiles as $file) {
  $f['name'] = substr($file, $l);
  $f['size'] = filesize($file);
  $f['time'] = filemtime($file);
  $f['time'] = date(PHP_DATE_TIME_FORMAT, $f['time']);
  $f['perms'] = fileperms($file);
  $f['perms'] = substr(sprintf('%o', $f['perms']), -4);
  $class = '';
  $comments = '';
  $type = '';
  $items = '';
  if (!is_writable($file)) {
    $class .= ' alert';
    $comments .= ' ' . TEXT_SITEMAPXML_FILE_LIST_COMMENTS_READONLY;
  }
  if ($f['name'] == $indexFile) {
    $class .= ' index';
  }
  if ($f['size'] == 0) {
    $class .= ' zero';
    $comments .= ' ' . TEXT_SITEMAPXML_FILE_LIST_COMMENTS_IGNORED;
  }
  if ($f['size'] > 0) {
    if ($fp = fopen($file, 'r')) {
      $contents = '';
      while (!feof($fp)) {
        $contents .= fread($fp, 8192);
      }
      fclose($fp);
      if (strpos($contents, '</urlset>') !== false) {
        $type = TEXT_SITEMAPXML_FILE_LIST_TYPE_URLSET;
        $items = substr_count($contents, '</url>');
      } elseif (strpos($contents, '</sitemapindex>') !== false) {
        $type = TEXT_SITEMAPXML_FILE_LIST_TYPE_SITEMAPINDEX;
        $items = substr_count($contents, '</sitemap>');
      } else {
        $type = TEXT_SITEMAPXML_FILE_LIST_TYPE_UNDEFINED;
        $items = '';
      }
      unset($contents);
    } else {
      $items = '<span style="color:red">' . 'Error!!!' . '</span>';
    }
  }
?>
                    <tr class="dataTableRow<?php echo $class; ?>" onmouseout="rowOutEffect(this)" onmouseover="rowOverEffect(this)">
                      <td class="dataTableContent"><a href="<?php echo HTTP_CATALOG_SERVER . DIR_WS_CATALOG . $f['name']; ?>" target="_blank"><?php echo $f['name']; ?>&nbsp;<?php echo zen_image(DIR_WS_IMAGES . 'icon_popup.gif', TEXT_SITEMAPXML_IMAGE_POPUP_ALT, '10', '10'); ?></a></td>
                      <td class="dataTableContent center<?php echo $class; ?>"><?php echo $f['size']; ?></td>
                      <td class="dataTableContent center<?php echo $class; ?>"><?php echo $f['time']; ?></td>
                      <td class="dataTableContent center<?php echo $class; ?>"><?php echo $f['perms']; ?></td>
                      <td class="dataTableContent center<?php echo $class; ?>"><?php echo $type; ?></td>
                      <td class="dataTableContent center<?php echo $class; ?>"><?php echo $items; ?></td>
                      <td class="dataTableContent center<?php echo $class; ?>"><?php echo trim($comments); ?></td>
                      <td class="dataTableContent right<?php echo $class; ?>">
<?php
if ($f['size'] > 0) {
  echo zen_draw_form('view_file', FILENAME_SITEMAPXML, '', 'post', 'target="_blank"') . zen_draw_hidden_field('action', 'view_file') . zen_draw_hidden_field('file', $f['name']) . '<input type="submit" value="' . TEXT_ACTION_VIEW_FILE . '" />' . '</form>';
  echo zen_draw_form('truncate_file', FILENAME_SITEMAPXML, '', 'post', 'onsubmit="return confirm(\'' . sprintf(TEXT_ACTION_TRUNCATE_FILE_CONFIRM, $f['name']) . '\');"') . zen_draw_hidden_field('action', 'truncate_file') . zen_draw_hidden_field('file', $f['name']) . '<input type="submit" value="' . TEXT_ACTION_TRUNCATE_FILE . '" />' . '</form>';
}
echo zen_draw_form('delete_file', FILENAME_SITEMAPXML, '', 'post', 'onsubmit="return confirm(\'' . sprintf(TEXT_ACTION_DELETE_FILE_CONFIRM, $f['name']) . '\');"') . zen_draw_hidden_field('action', 'delete_file') . zen_draw_hidden_field('file', $f['name']) . '<input type="submit" value="' . TEXT_ACTION_DELETE_FILE . '" />' . '</form>';
?>
                      </td>
                    </tr>
<?php
}
?>
                  </table>
                  <br><a class="link_button" title="<?php echo TEXT_SITEMAPXML_RELOAD_WINDOW; ?>" href="javascript: window.location.reload()"><?php echo TEXT_SITEMAPXML_RELOAD_WINDOW; ?></a>
                </fieldset>
                 </div>
               </td>
            </tr>
            <tr>
              <td>
                <h3><?php echo TEXT_SITEMAPXML_TIPS_HEAD; ?></h3>
                <div id="overviewTips">
                  <?php echo TEXT_SITEMAPXML_TIPS_TEXT; ?>
                </div>
              </td>
            </tr>

           

          </table>
        </td>
      </tr>

      <tr><td class="smallText center">Sitemap XML &copy; 2004-<?php echo date('Y'); ?> Andrew Berezin</td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
