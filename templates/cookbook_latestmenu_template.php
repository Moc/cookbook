<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Latest recipes menu template
*/

if (!defined('e107_INIT')) { exit; }

$COOKBOOK_LATESTMENU_TEMPLATE = array();
          
$COOKBOOK_LATESTMENU_TEMPLATE['default']['caption'] = '{COOKBOOK_LATESTMENU_CAPTION}';
$COOKBOOK_LATESTMENU_TEMPLATE['default']['start']   = '<div class="cookbook_latest_menu">';
$COOKBOOK_LATESTMENU_TEMPLATE['default']['item']    = "{COOKBOOK_RECIPE_NAME=no_url} <br>";
$COOKBOOK_LATESTMENU_TEMPLATE['default']['end']     = '</div>';