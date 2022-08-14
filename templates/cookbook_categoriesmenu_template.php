<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Categories menu template
*/

if (!defined('e107_INIT')) { exit; }

$COOKBOOK_CATEGORIESMENU_TEMPLATE = array();
          
$COOKBOOK_CATEGORIESMENU_TEMPLATE['default']['caption'] = '{COOKBOOK_CATEGORIESMENU_CAPTION}';
$COOKBOOK_CATEGORIESMENU_TEMPLATE['default']['start']   = '<div class="cookbook_categories_menu">';
$COOKBOOK_CATEGORIESMENU_TEMPLATE['default']['item']    = "{COOKBOOK_CATEGORY_NAME} <span class='badge text-right'>{COOKBOOK_RECIPES_IN_CATEGORY}</span><br>";
$COOKBOOK_CATEGORIESMENU_TEMPLATE['default']['end']     = '</div>';